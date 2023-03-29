<?php

namespace Vitaliy\PhpPro2\Shorter;

use Vitaliy\PhpPro2\Shorter\UrlShortener;
use InvalidArgumentException;

use Vitaliy\PhpPro2\Shorter\UrlValidator;

class UrlShortenerCLI
{
    private UrlShortener $shortener;


    public function __construct(UrlShortener $shortener) 
  {
      $this->shortener = $shortener;
  }

    public function handle(array $args): void
    {
        $command = $args[1] ?? '';

        if ($command === 'shorten') {
            $url = $args[2] ?? '';
            try {
                $code = $this->shortener->encode($url);
                echo "Shortened URL: {$code}\n";
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage() . "\n";
                exit(1);
            }
        } elseif ($command === 'expand') {
            $code = $args[2] ?? '';
            try {$url = $this->shortener->decode($code);
                echo "Expanded URL: {$url}\n";
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage() . "\n";
                exit(1);
            }
        } else {
            echo "Invalid command\n";
            exit(1);
        }
    }
}