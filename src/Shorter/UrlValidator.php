<?php

namespace Vitaliy\PhpPro2\Shorter;

use InvalidArgumentException;
use Vitaliy\PhpPro2\Shorter\Interfaces\LoggerInterface;



class UrlValidator
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function validate(string $url): void
    {
        // Validate the URL
        if (!(filter_var($url, FILTER_VALIDATE_URL))) {
            $this->logger->error('Invalid URL: ' . $url);
            throw new InvalidArgumentException('Invalid URL');
        }

        $this->logger->info('Valid URL: ' . $url);
    }
}