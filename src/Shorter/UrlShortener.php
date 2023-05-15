<?php

namespace Vitaliy\PhpPro2\Shorter;

use Vitaliy\PhpPro2\Shorter\Interfaces\ICodeStorageInterface;
use Vitaliy\PhpPro2\Shorter\Interfaces\IUrlDecoder;
use Vitaliy\PhpPro2\Shorter\Interfaces\IUrlEncoder;
use Vitaliy\PhpPro2\Shorter\UrlValidator;
use Psr\Log\LoggerInterface;

use InvalidArgumentException;

class UrlShortener implements IUrlEncoder, IUrlDecoder
{
    const CODE_LENGTH = 10;



    public function __construct(protected UrlValidator $validator, protected ICodeStorageInterface $storage, protected LoggerInterface $logger)
    {
    }

    public function encode(string $url): string
    {
        try {
            $this->validator->validate($url);

            // Generate a random code
            $code = substr(md5(mt_rand()), 0, self::CODE_LENGTH);

            // Save the code to a file
            $this->storage->save($code, $url);

            $this->logger->info("URL encoded: {$url} -> {$code}");

            return $code;
        }
        catch (\Exception $e) {
            $this->logger->error("Failed to encode URL: {$url}", ['exception' => $e]);
            throw $e;
        }
    }

    public function decode(string $code): string
    {
        try {
            $url = $this->storage->find($code);

            if ($url === null) {
                throw new InvalidArgumentException('Code not found');
            }

            $this->validator->validate($url);

            $this->logger->info("URL decoded: {$code} -> {$url}");

            return $url;
        } catch (\Exception $e) {
            $this->logger->error("Failed to decode URL: {$code}", ['exception' => $e]);
            throw $e;
        }
    }
}