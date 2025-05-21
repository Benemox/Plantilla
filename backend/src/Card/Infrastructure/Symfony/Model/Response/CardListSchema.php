<?php

namespace App\Card\Infrastructure\Symfony\Model\Response;

class CardListSchema
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $bank,
        public ?float $annualFee,
        public ?float $transactionFee,
        public bool $bonusProgram,
        public ?string $logo,
        public ?string $link
    ) {
    }
}
