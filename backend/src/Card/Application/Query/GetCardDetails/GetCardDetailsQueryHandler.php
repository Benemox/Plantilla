<?php

namespace App\Card\Application\Query\GetCardDetails;

use App\Card\Domain\Exception\InvalidCardNotFoundException;
use App\Card\Domain\Repository\CardRepositoryInterface;
use App\Card\Infrastructure\Symfony\Model\Response\CardDetailsSchema;
use App\Shared\Domain\Bus\HandlerInterface;
use Symfony\Component\Uid\Uuid;

class GetCardDetailsQueryHandler implements HandlerInterface
{
    private CardRepositoryInterface $cardRepository;

    public function __construct(CardRepositoryInterface $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function __invoke(GetCardDetailsQuery $query): CardDetailsSchema
    {
        $card = $this->cardRepository->findById($query->cardId);

        if ($card === null) {
            throw InvalidCardNotFoundException::NotFound($query->cardId);
        }
        return new CardDetailsSchema(
            id: (string) $card->getId(),
            name: $card->getName(),
            bank: $card->getBank(),
            features: $card->getFeatures(),
            annualFee: $card->getAnnualFee(),
            transactionFee: $card->getTransactionFee(),
            cardType: $card->getCardType(),
            logo: $card->getLogo(),
            link: $card->getLink()
        );
    }
}
