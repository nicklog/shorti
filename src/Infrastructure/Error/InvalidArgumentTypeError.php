<?php

declare(strict_types=1);

namespace App\Infrastructure\Error;

use InvalidArgumentException;
use Throwable;

use function get_debug_type;
use function sprintf;

final class InvalidArgumentTypeError extends InvalidArgumentException
{
    public function __construct(
        string $expectedType,
        mixed $actualType,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $message = sprintf('Expected argument of type "%s", "%s" given', $expectedType, get_debug_type($actualType));

        parent::__construct($message, $code, $previous);
    }
}
