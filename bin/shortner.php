<?php


require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Vitaliy\PhpPro2\Shorter\UrlShortenerCLI;
use Vitaliy\PhpPro2\Shorter\UrlShortener;
use Vitaliy\PhpPro2\Shorter\UrlValidator;
use Vitaliy\PhpPro2\Shorter\CodeFileStorage;
use Vitaliy\PhpPro2\Shorter\DbConnector;
use Illuminate\Database\Capsule\Manager as Capsule;
use Vitaliy\PhpPro2\Shorter\CodeDbStorage;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'php_pro_2_mysql',
    'database' => 'php_pro',
    'username' => 'doctor',
    'password' => 'pass4doctor',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$capsule->setAsGlobal();






try {
    $logFile = __DIR__.'/../app.log';
    $monologLogger = new Logger('url_shortener');
    $monologLogger->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
    $validator = new UrlValidator($monologLogger);
//    $storage = new CodeFileStorage();
    $storage = new CodeDbStorage();
    $shortener = new UrlShortener($validator, $storage, $monologLogger);
    $cli = new UrlShortenerCLI($shortener, $monologLogger);
    $cli->handle($argv);
} catch (\Exception $e) {
    echo $e->getMessage();
}

