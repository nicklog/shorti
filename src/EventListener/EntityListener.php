<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Common\AbstractEntity;
use App\Infrastructure\Clock\Clock;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

final class EntityListener implements EventSubscriber
{
    public function __construct(
        private readonly Clock $clock
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::postLoad,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        $this->updateUpdatedAt($entity);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        $this->updateUpdatedAt($entity);
    }

    public function postLoad(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        $this->updateUpdatedAt($entity);

        $args->getEntityManager()->persist($entity);
    }

    private function updateUpdatedAt(mixed $entity): void
    {
        if (! ($entity instanceof AbstractEntity)) {
            return;
        }

        $entity->setUpdated($this->clock->now());
    }
}
