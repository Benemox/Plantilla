<?php

namespace App\Provider\FinanceAds\Infrastructure\Mapper;

class CardMapper
{
    public function map(array $product): array
    {
        return [
            'id' => (int) ($product['@attributes']['id'] ?? 0),
            'name' => $product['produkt'] ?? 'Unknown Card',
            'bank' => $product['bank'] ?? null,
            'features' => [
                'bonus_program' => $product['bonusprogram'] ?? '0',
                'cashback' => $product['cashback'] ?? '0',
                'insurances' => $product['insurances'] ?? '0',
            ],
            'annualFee' => (float) str_replace(',', '.', $product['gebuehren'] ?? '0'),
            'transactionFee' => (float) str_replace(',', '.', $product['kosten'] ?? '0'),
            'cardType' => $product['cardtype_text'] ?? null,
            'logo' => $product['logo'] ?? null,
            'link' => $product['link'] ?? null,
        ];
    }
}
