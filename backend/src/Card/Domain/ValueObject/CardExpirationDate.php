<?php

declare(strict_types=1);

namespace App\Card\Domain\ValueObject;

use App\Card\Domain\Exception\InvalidCardExpirationDateException;
use DateTimeImmutable;

final class CardExpirationDate
{
    private DateTimeImmutable $expirationDate;

    public function __construct(string $expirationDate)
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $expirationDate);

        if (!$date) {
            throw InvalidCardExpirationDateException::fromInvalidFormat($expirationDate);
        }

        if ($date < new DateTimeImmutable('today midnight')) {
            throw InvalidCardExpirationDateException::fromPastDate($expirationDate);
        }

        $this->expirationDate = $date;
    }

    public function value(): DateTimeImmutable
    {
        return $this->expirationDate;
    }

    public function __toString(): string
    {
        return $this->expirationDate->format('Y-m-d');
    }
}
