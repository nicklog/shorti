<?php

declare(strict_types=1);

namespace App\Util;

use RandomLib\Factory;

use function sha1;

final class ShortyUtil
{
    private function __construct()
    {
    }

    public static function getHash(string $url): string
    {
        return sha1($url);
    }

    public static function generateCode(): string
    {
        return (new Factory())
            ->getMediumStrengthGenerator()
            ->generateString(6, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    }
}
