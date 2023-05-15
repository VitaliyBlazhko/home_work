<?php

namespace Vitaliy\PhpPro2\Shorter;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;



class UrlValidator
{

    public function __construct(protected LoggerInterface $logger)
    {
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