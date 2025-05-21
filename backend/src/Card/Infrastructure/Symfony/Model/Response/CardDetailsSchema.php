<?php

namespace App\Card\Infrastructure\Symfony\Model\Response;

class CardDetailsSchema
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $bank,
        public array $features,
        public ?float $annualFee,
        public ?float $transactionFee,
        public ?string $cardType,
        public ?string $logo,
        public ?string $link
    ) {
    }
}
