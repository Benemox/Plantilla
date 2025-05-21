<?php

namespace App\Card\Application\Query\ListCards;

use App\Card\Domain\Repository\CardRepositoryInterface;
use App\Card\Infrastructure\Symfony\Model\Response\CardListSchema;
use App\Shared\Domain\Bus\HandlerInterface;

class ListCardsQueryHandler implements HandlerInterface
{
    public function __construct(private CardRepositoryInterface $cardRepository)
    {
    }

    public function __invoke(ListCardsQuery $query): array
    {
        $cards = $this->cardRepository->findAllOrderedByPrice(
            $query->bonusProgram,
            $query->sortBy,
            $query->order,
        );

        return array_map(fn($card) => new CardListSchema(
            id: $card->getId(),
            name: $card->getName(),
            bank: $card->getBank(),
            annualFee: $card->getAnnualFee(),
            transactionFee: $card->getTransactionFee(),
            bonusProgram: $card->getBonusProgram(),
            logo: $card->getLogo(),
            link: $card->getLink()
        ), $cards);
    }
}
