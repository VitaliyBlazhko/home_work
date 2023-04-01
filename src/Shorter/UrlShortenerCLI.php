<?php

namespace Vitaliy\PhpPro2\Shorter;

use Vitaliy\PhpPro2\Shorter\UrlShortener;
use InvalidArgumentException;
use Vitaliy\PhpPro2\Shorter\Interfaces\LoggerInterface;

use Vitaliy\PhpPro2\Shorter\UrlValidator;

class UrlShortenerCLI
{
    private UrlShortener $shortener;
    private LoggerInterface $logger;

    public function __construct(UrlShortener $shortener, LoggerInterface $logger)
    {
        $this->shortener = $shortener;
        $this->logger = $logger;
    }

    public function handle(array $args): void
    {
        $command = $args[1] ?? '';

        if ($command === 'shorten') {
            $url = $args[2] ?? '';
            try {
                $code = $this->shortener->encode($url);
                $this->logger->info("Shortened URL: {$code}");
                echo "Shortened URL: {$code}\n";
            } catch (InvalidArgumentException $e) {
                $this->logger->error($e->getMessage());
                echo $e->getMessage() . "\n";
                exit(1);
            }
        } elseif ($command === 'expand') {
            $code = $args[2] ?? '';
            try {
                $url = $this->shortener->decode($code);
                $this->logger->info("Expanded URL: {$url}");
                echo "Expanded URL: {$url}\n";
            } catch (InvalidArgumentException $e) {
                $this->logger->error($e->getMessage());
                echo $e->getMessage() . "\n";
                exit(1);
            }
        } else {
            $this->logger->error("Invalid command");
            echo "Invalid command\n";
            exit(1);
        }
    }
}