<?php


require_once __DIR__ . '/../vendor/autoload.php';

use Vitaliy\PhpPro2\Shorter\UrlShortenerCLI;
use Vitaliy\PhpPro2\Shorter\UrlShortener;
use Vitaliy\PhpPro2\Shorter\UrlValidator;
use Vitaliy\PhpPro2\Shorter\CodeFileStorage;

try {
    $validator = new UrlValidator();
    $storage = new CodeFileStorage();
    $shortener = new UrlShortener($validator, $storage);
    $cli = new UrlShortenerCLI($shortener);
    $cli->handle($argv);
} catch (\Exception $e) {
    echo $e->getMessage();
}
