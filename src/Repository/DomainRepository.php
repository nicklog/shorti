<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Domain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Domain|null find($id, ?int $lockMode = null, ?int $lockVersion = null)
 * @method Domain[] findAll()
 * @method Domain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Domain[] findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = null)
 */
final class DomainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Domain::class);
    }
}
