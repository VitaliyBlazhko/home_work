<?php

namespace Vitaliy\PhpPro2\Shorter\Interfaces;



interface IUrlDecoder
{
    /**
     * @param string $code
     * @throws \InvalidArgumentException
     * @return string
     */
    public function decode(string $code): string;
}
