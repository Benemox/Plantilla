<?php

declare(strict_types=1);

namespace App\Card\Domain\Exception;

use App\Shared\Domain\Contracts\CustomExceptionInterface;
use App\Shared\Domain\Exception\DomainException;
use InvalidArgumentException;

final class InvalidCardExpirationDateException extends DomainException implements CustomExceptionInterface
{
    protected const DOMAIN = 'errors';
    public static function fromInvalidFormat(string $date): self
    {
        return new self(sprintf('Invalid card expiration date format provided: "%s". Expected format: YYYY-MM-DD.', $date), 400);
    }

    public static function fromPastDate(string $date): self
    {
        return new self(sprintf('Card expiration date "%s" cannot be in the past.', $date), 400);
    }

    public function getCustomCode(): string
    {
        return $this->code;
    }

    public function getDomain(): string
    {
        return self::DOMAIN;
    }
}
