<?php

namespace Vitaliy\PhpPro2\Shorter\Interfaces;
use Monolog\Logger;

interface LoggerInterface
{
    public function error(string $message, array $context = []): void;
    public function info(string $message, array $context = []): void;
    public function debug(string $message, array $context = []): void;
    public function getLogger(): Logger;
}