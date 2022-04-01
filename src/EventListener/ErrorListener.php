<?php

declare(strict_types=1);

namespace App\EventListener;

use NunoMaduro\Collision\Writer;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Whoops\Exception\Inspector;

#[AsEventListener]
final class ErrorListener
{
    public function __invoke(ConsoleErrorEvent $event): void
    {
        $error = $event->getError();

        if ($error instanceof ExceptionInterface) {
            return;
        }

        $writer = new Writer();
        $writer->setOutput($event->getOutput());
        $writer->write(new Inspector($error));

        $event->setExitCode(0);
    }
}
