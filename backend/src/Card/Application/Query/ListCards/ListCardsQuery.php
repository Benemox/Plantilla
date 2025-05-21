<?php

namespace App\Card\Application\Query\ListCards;

use App\Shared\Domain\Bus\QueryMessageInterface;

class ListCardsQuery implements QueryMessageInterface
{
    public function __construct(
        public ?bool $bonusProgram = null,
        public ?string $sortBy = 'name',
        public ?string $order = 'asc'
    ) {
    }
}
