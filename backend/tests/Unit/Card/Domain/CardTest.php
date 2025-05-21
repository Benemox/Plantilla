<?php

namespace App\Tests\Unit\Card\Domain;

use App\Card\Domain\Entity\Card;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{
    public function testCreateCard(): void
    {
        $card = new Card(
            1,
            'Tarjeta You',
            'Advanzia Bank S.A.',
            ['bonus_program' => '1', 'insurances' => '0'],
            '0.00',
            '0.00',
            'credit',
            'https://example.com/logo.jpg',
            'https://example.com/link'
        );

        $this->assertEquals(1, $card->getId());
        $this->assertEquals('Tarjeta You', $card->getName());
        $this->assertEquals('Advanzia Bank S.A.', $card->getBank());
        $this->assertEquals(['bonus_program' => '1', 'insurances' => '0'], $card->getFeatures());
        $this->assertEquals('0.00', $card->getAnnualFee());
        $this->assertEquals('0.00', $card->getTransactionFee());
        $this->assertEquals('credit', $card->getCardType());
        $this->assertEquals('https://example.com/logo.jpg', $card->getLogo());
        $this->assertEquals('https://example.com/link', $card->getLink());
    }

    public function testGetBonusProgram(): void
    {
        $card = new Card(
            1,
            'Tarjeta Test',
            'Bank Test',
            ['bonus_program' => '1'],
            '10.00',
            '5.00',
            'credit',
            null,
            null
        );

        $this->assertEquals('1', $card->getFeatures()['bonus_program']);
    }
}
