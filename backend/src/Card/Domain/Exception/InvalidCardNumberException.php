<?php

declare(strict_types=1);

namespace App\Card\Domain\Exception;

use App\Shared\Domain\Contracts\CustomExceptionInterface;
use App\Shared\Domain\Exception\DomainException;
use InvalidArgumentException;

final class InvalidCardNumberException extends DomainException implements CustomExceptionInterface
{
    protected const DOMAIN = 'errors';
    public static function fromInvalidNumber(string $number): self
    {
        return new self(sprintf('Invalid card number provided: "%s".', $number), 404);
    }

    public function getCustomCode(): string
    {
        return $this->message;
    }

    public function getDomain(): string
    {
        return self::DOMAIN;
    }
}
