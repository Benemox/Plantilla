<?php

declare(strict_types=1);

namespace App\Card\Domain\Exception;

use App\Shared\Domain\Contracts\CustomExceptionInterface;
use App\Shared\Domain\Exception\DomainException;

final class InvalidCardNotFoundException extends DomainException implements CustomExceptionInterface
{
    protected const DOMAIN = 'errors';
    public static function NotFound(string $id): self
    {
        return new self(sprintf('Invalid card not found, provided: "%s".', $id), 404);
    }

    public static function InvalidCardId(string $id): self
    {
        return new self(sprintf('Invalid card id provided, provided: "%s".', $id), 400);
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
