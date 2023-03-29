<?php


require_once __DIR__ . '/../vendor/autoload.php';

use Vitaliy\PhpPro2\Shorter\UrlShortenerCLI;
use Vitaliy\PhpPro2\Shorter\UrlShortener;
use Vitaliy\PhpPro2\Shorter\UrlValidator;

try {
    $validator = new UrlValidator();
    $shortener = new UrlShortener($validator);
    $cli = new UrlShortenerCLI($shortener);
    $cli->handle($argv);
} catch (\Exception $e) {
    echo $e->getMessage();
}
