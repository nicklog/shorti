<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<Visit>
 */
final class VisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visit::class);
    }

    public function countAll(): int
    {
        return (int) $this
            ->getEntityManager()
            ->createQuery(
                <<<'DQL'
                    SELECT COUNT(1)
                    FROM App\Entity\Visit s
                DQL
            )
            ->getSingleScalarResult();
    }
}
