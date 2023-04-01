<?php

namespace Vitaliy\PhpPro2\Shorter;

use Vitaliy\PhpPro2\Shorter\Interfaces\IUrlDecoder;
use Vitaliy\PhpPro2\Shorter\Interfaces\IUrlEncoder;
use Vitaliy\PhpPro2\Shorter\UrlValidator;
use Vitaliy\PhpPro2\Shorter\Interfaces\LoggerInterface;

use InvalidArgumentException;

class UrlShortener implements IUrlEncoder, IUrlDecoder
{
    const CODE_LENGTH = 10;

    private UrlValidator $validator;
    private CodeFileStorage $storage;
    private LoggerInterface $logger;

    public function __construct(UrlValidator $validator, CodeFileStorage $storage, LoggerInterface $logger)
    {
        $this->validator = $validator;
        $this->storage = $storage;
        $this->logger = $logger;
        $this->validator->__construct($logger);
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