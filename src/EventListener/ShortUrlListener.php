<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\ShortUrl;
use App\Util\ShortyUtil;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

final class ShortUrlListener implements EventSubscriber
{
    /**
     * @return string[]
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist => 'prePersist',
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if (! $entity instanceof ShortUrl) {
            return;
        }

        if ($entity->getCode() !== null) {
            return;
        }

        $entity->setCode(ShortyUtil::generateCode());
    }
}
