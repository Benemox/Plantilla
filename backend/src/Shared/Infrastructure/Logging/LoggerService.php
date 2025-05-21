<?php

namespace App\Shared\Infrastructure\Logging;

use Psr\Log\LoggerInterface;

class LoggerService
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logDebug(string $message, array $context = []): void
    {
        $this->logger->debug($message, $context);
    }

    public function logInfo(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function logWarning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }

    public function logError(string $message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }

    public function logCritical(string $message, array $context = []): void
    {
        $this->logger->critical($message, $context);
    }
}
