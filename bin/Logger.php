<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Vitaliy\PhpPro2\Shorter\UrlShortenerCLI;
use Vitaliy\PhpPro2\Shorter\UrlShortener;
use Vitaliy\PhpPro2\Shorter\UrlValidator;
use Vitaliy\PhpPro2\Shorter\CodeFileStorage;
use Vitaliy\PhpPro2\Shorter\MonologAdapter;

$logFile = __DIR__.'/../app.log';
$monologLogger = new Logger('url_shortener');
$monologLogger->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
$loggerAdapter = new MonologAdapter($monologLogger);

$validator = new UrlValidator($loggerAdapter);
$storage = new CodeFileStorage();
$shortener = new UrlShortener($validator, $storage, $loggerAdapter);

$cli = new UrlShortenerCLI($shortener, $loggerAdapter);
$cli->handle($argv);