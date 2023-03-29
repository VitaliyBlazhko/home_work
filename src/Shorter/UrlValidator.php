<?php

namespace Vitaliy\PhpPro2\Shorter;

use InvalidArgumentException;



class UrlValidator
{
    
    public function validate(string $url): void
    {
        // Validate the URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid URL');
        }


    }
}