<?php

namespace App\Provider\FinanceAds\Domain\Exception;

use App\Shared\Domain\Contracts\CustomExceptionInterface;
use App\Shared\Domain\Exception\DomainException;

final class ApiFinanceException extends DomainException implements CustomExceptionInterface
{
    protected const DOMAIN = 'api';

    public static function fromHttpError(int $statusCode, string $url): self
    {
        return new self(sprintf('API request to "%s" failed with HTTP status code %d.', $url, $statusCode), 500);
    }

    public static function fromInvalidResponseFormat(string $url): self
    {
        return new self(sprintf('Invalid response format received from API: "%s".', $url), 500);
    }

    public function getCustomCode(): string
    {
        return (string) $this->code;
    }

    public function getDomain(): string
    {
        return self::DOMAIN;
    }
}
