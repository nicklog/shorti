<?php

declare(strict_types=1);

namespace App\Entity\Common;

use App\Infrastructure\Error\InvalidArgumentTypeError;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractEntity implements Entity
{
    use Modified;

    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected ?int $id = null;

    public function __construct()
    {
        $this->created = Carbon::now();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isPersisted(): bool
    {
        return $this->id !== null;
    }

    public function equals(?self $self): bool
    {
        if (! $self instanceof static) {
            throw new InvalidArgumentTypeError(static::class, $self);
        }

        return $this->getId() === $self->getId();
    }
}
