<?php

namespace Vitaliy\PhpPro2\Shorter\Interfaces;

interface ICodeStorageInterface
{
    public function save(string $code, string $url): void;
    public function find(string $code): ?string;

}