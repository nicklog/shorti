<?php

declare(strict_types=1);

namespace App\Infrastructure\Clock;

use Carbon\CarbonImmutable;
use DateTimeInterface;

final class FrozenClock implements Clock
{
    private CarbonImmutable $now;

    public function __construct(DateTimeInterface $now)
    {
        $this->setTo($now);
    }

    public function setTo(DateTimeInterface $now): void
    {
        $this->now = CarbonImmutable::parse($now);
    }

    public function now(): CarbonImmutable
    {
        return $this->now;
    }
}
