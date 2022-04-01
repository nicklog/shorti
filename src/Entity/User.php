<?php

declare(strict_types=1);

namespace App\Entity;

use App\Domain\Role;
use App\Entity\Common\AbstractEntity;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use function array_map;
use function array_search;
use function array_unique;
use function implode;
use function in_array;
use function sprintf;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends AbstractEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(type: 'string', nullable: false)]
    private string $email;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean', nullable: false, options: ['default' => true])]
    private bool $enable = true;

    /** @var string[] */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    public function __construct(
        string $email
    ) {
        parent::__construct();

        $this->email = $email;
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function isEnable(): bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantee every user at least has ROLE_USER
        $roles[] = Role::USER->value;

        return array_unique($roles);
    }

    public function addRole(string | Role $role): void
    {
        if ($role instanceof Role) {
            $role = $role->value;
        }

        if (in_array($role, $this->roles, true)) {
            return;
        }

        if (Role::tryFrom($role) === null) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s given but $role has to be one of these values: %s',
                    $role,
                    implode(', ', array_map(static fn (Role $role) => $role->value, Role::cases()))
                )
            );
        }

        $this->roles[] = $role;
    }

    public function removeRole(string | Role $role): void
    {
        if ($role instanceof Role) {
            $role = $role->value;
        }

        if (! in_array($role, $this->roles, true)) {
            return;
        }

        unset($this->roles[array_search($role, $this->roles, true)]);
    }

    public function eraseCredentials(): void
    {
    }
}
