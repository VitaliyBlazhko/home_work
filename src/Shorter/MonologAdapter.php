<?php


namespace Vitaliy\PhpPro2\Shorter;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Vitaliy\PhpPro2\Shorter\Interfaces\LoggerInterface;
use Vitaliy\PhpPro2\Shorter\UrlShortener;

class MonologAdapter implements LoggerInterface
{
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function error(string $message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }

    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function debug(string $message, array $context = []): void
    {
        $this->logger->debug($message, $context);
    }

    /**
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }
}