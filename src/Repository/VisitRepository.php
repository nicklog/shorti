<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Visit|null find($id, ?int $lockMode = null, ?int $lockVersion = null)
 * @method Visit[] findAll()
 * @method Visit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visit[] findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = null)
 */
final class VisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visit::class);
    }
}
