<?php

declare(strict_types=1);

namespace App\Infrastructure\Clock;

use Carbon\CarbonImmutable;
use DateTimeZone;

final class SystemClock implements Clock
{
    public function __construct(
        private readonly DateTimeZone $timezone = new DateTimeZone('UTC')
    ) {
    }

    public function now(): CarbonImmutable
    {
        return CarbonImmutable::parse('now', $this->timezone);
    }
}
