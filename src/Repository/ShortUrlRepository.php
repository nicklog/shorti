<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ShortUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;
use RuntimeException;

use function get_debug_type;
use function sprintf;

/**
 * @template-extends ServiceEntityRepository<ShortUrl>
 */
final class ShortUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortUrl::class);
    }

    public function findOneByCode(string $code): ?ShortUrl
    {
        $result = $this
            ->getEntityManager()
            ->createQuery(
                <<<'DQL'
                    SELECT s
                    FROM App\Entity\ShortUrl s
                    WHERE BINARY(s.code) = :code
                DQL
            )
            ->setParameter('code', $code, Types::STRING)
            ->getOneOrNullResult();

        if ($result === null) {
            return null;
        }

        if (! $result instanceof ShortUrl) {
            throw new RuntimeException(
                sprintf('Result is type of %s, but should be %s', get_debug_type($result), ShortUrl::class),
                1649762762410
            );
        }

        return $result;
    }

    /**
     * @return ShortUrl[]
     */
    public function findRecentlyCreated(): array
    {
        return $this
            ->getEntityManager()
            ->createQuery(
                <<<'DQL'
                    SELECT s
                    FROM App\Entity\ShortUrl s
                    ORDER BY s.created DESC
                DQL
            )
            ->getResult();
    }

    public function countAll(): int
    {
        return (int) $this
            ->getEntityManager()
            ->createQuery(
                <<<'DQL'
                    SELECT COUNT(1)
                    FROM App\Entity\ShortUrl s
                DQL
            )
            ->getSingleScalarResult();
    }
}
