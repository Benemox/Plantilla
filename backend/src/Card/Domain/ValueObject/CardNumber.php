<?php

declare(strict_types=1);

namespace App\Card\Domain\ValueObject;

use App\Card\Domain\Exception\InvalidCardNumberException;
use InvalidArgumentException;

final class CardNumber
{
    private string $number;

    public function __construct(string $number)
    {
        $cleanNumber = preg_replace('/\D/', '', $number);

        $this->number = $cleanNumber;
    }

    public function value(): string
    {
        return $this->number;
    }

    public function __toString(): string
    {
        return $this->number;
    }
}
