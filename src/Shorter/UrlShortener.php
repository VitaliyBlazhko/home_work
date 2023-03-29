<?php

namespace Vitaliy\PhpPro2\Shorter;

use Vitaliy\PhpPro2\Shorter\Interfaces\IUrlDecoder;
use Vitaliy\PhpPro2\Shorter\Interfaces\IUrlEncoder;
use Vitaliy\PhpPro2\Shorter\UrlValidator;

use InvalidArgumentException;

class UrlShortener implements IUrlEncoder, IUrlDecoder
{
    const CODE_LENGTH = 10;
    const CODE_FILE = __DIR__ . '/../../short_urls2.txt';

    private UrlValidator $validator;

    public function __construct(UrlValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param string $url
     * @return string
     * @throws InvalidArgumentException
     */
    public function encode(string $url): string
    {
        $this->validator->validate($url);

        // Generate a random code
        $code = substr(md5(mt_rand()), 0, self::CODE_LENGTH);

        // Save the code to a file
        file_put_contents(self::CODE_FILE, "{$code} {$url}\n", FILE_APPEND);

        return $code;
    }

    /**
     * @param string $code
     * @return string
     * @throws InvalidArgumentException
     */
    public function decode(string $code): string
    {
        // Read the short URLs file and find the URL corresponding to the given code
        $lines = file(self::CODE_FILE);
        foreach ($lines as $line) {
            list($savedCode, $url) = explode(' ', trim($line));
            if ($savedCode === $code) {
                $this->validator->validate($url);

                return $url;
            }
        }

        throw new InvalidArgumentException('Code not found');
    }
}