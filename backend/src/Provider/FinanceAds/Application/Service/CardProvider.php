<?php

namespace App\Provider\FinanceAds\Application\Service;

use App\Card\Domain\Entity\Card;
use App\Card\Domain\Repository\CardRepositoryInterface;
use App\Provider\FinanceAds\Infrastructure\Http\CardApiClient;
use App\Provider\FinanceAds\Infrastructure\Mapper\CardMapper;

class CardProvider
{
    public function __construct(
        private CardRepositoryInterface $cardRepository,
        private CardApiClient $cardApiClient,
        private CardMapper $cardMapper
    ) {
    }

    public function importCards(): void
    {
        $products = $this->cardApiClient->fetchCards();

        foreach ($products as $product) {
            $cardData = $this->cardMapper->map($product);
            $existingCard = $this->cardRepository->findById($cardData['id']);

            if ($existingCard) {
                $existingCard->setName($cardData['name']);
                $existingCard->setBank($cardData['bank']);
                $existingCard->setFeatures($cardData['features']);
                $existingCard->setAnnualFee($cardData['annualFee']);
                $existingCard->setTransactionFee($cardData['transactionFee']);
                $existingCard->setCardType($cardData['cardType']);
                $existingCard->setLogo($cardData['logo']);
                $existingCard->setLink($cardData['link']);

                $this->cardRepository->save($existingCard);
            } else {
                try {
                    $newCard = new Card(
                        $cardData['id'],
                        $cardData['name'],
                        $cardData['bank'],
                        $cardData['features'],
                        $cardData['annualFee'],
                        $cardData['transactionFee'],
                        $cardData['cardType'],
                        $cardData['logo'],
                        $cardData['link']
                    );

                    $this->cardRepository->save($newCard);
                } catch (\Exception $e) {
                    echo "⚠ Skipping invalid card: " . $cardData['id'] . "\n";
                }
            }
        }
    }
}
