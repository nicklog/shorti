<?php

declare(strict_types=1);

namespace App\Infrastructure\Monolog\Processor;

use Monolog\Processor\ProcessorInterface;
use Throwable;

use function array_merge;

final class ExceptionProcessor implements ProcessorInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(array $record): array
    {
        $exception = $record['extra']['exception'] ?? null;

        if ($exception instanceof Throwable) {
            unset($record['extra']['exception']);

            $previousErrorSet = [];
            if ($exception->getPrevious() !== null) {
                $previousError    = $exception->getPrevious();
                $previousErrorSet = [
                    'previous_error' => $previousError->getMessage(),
                    'previous_file'  => $previousError->getFile(),
                    'previous_line'  => $previousError->getLine(),
                    'previous_trace' => $previousError->getTrace(),
                ];
            }

            $errorSet = [
                'error' => $exception->getMessage(),
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'trace' => $exception->getTrace(),
            ];

            $record['extra'] = array_merge(
                $record['extra'],
                $errorSet,
                $previousErrorSet
            );
        }

        return $record;
    }
}
