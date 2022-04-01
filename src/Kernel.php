<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

use function str_replace;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function getContainerClass(): string
    {
        return str_replace('\\', '_', static::class) . 'Container';
    }
}
