<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ShortUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShortUrl|null find($id, ?int $lockMode = null, ?int $lockVersion = null)
 * @method ShortUrl[] findAll()
 * @method ShortUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShortUrl[] findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = null)
 */
final class ShortUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortUrl::class);
    }

    public function findOneByCode(string $code): ?ShortUrl
    {
        return $this
            ->getEntityManager()
            ->createQuery(
                <<<'DQL'
                    SELECT s
                    FROM App\Entity\Shorty s
                    WHERE BINARY(s.code) = :code 
                DQL
            )
            ->setParameter('code', $code, Types::STRING)
            ->getOneOrNullResult();
    }
}