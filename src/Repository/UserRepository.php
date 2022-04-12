<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @template-extends ServiceEntityRepository<User>
 */
final class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function countAll(): int
    {
        return (int) $this->_em->createQuery(
            <<<'DQL'
                SELECT COUNT(1) 
                FROM App\Entity\User u 
            DQL
        )
            ->getSingleScalarResult();
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $result = $this->_em->createQuery(
            <<<'DQL'
                SELECT u 
                FROM App\Entity\User u 
                WHERE u.email = :username
            DQL
        )
            ->setParameter('username', $identifier, Types::STRING)
            ->getOneOrNullResult();

        if (! $result instanceof UserInterface) {
            throw new UserNotFoundException();
        }

        return $result;
    }
}
