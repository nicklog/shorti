<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\AbstractEntity;
use App\Repository\DomainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Entity(repositoryClass: DomainRepository::class)]
class Domain extends AbstractEntity implements Stringable
{
    /** @var Collection<int, ShortUrl> */
    #[ORM\ManyToMany(targetEntity: ShortUrl::class, mappedBy: 'domains', cascade: ['persist', 'remove'])]
    private Collection $shortUrls;

    #[ORM\Column(type: Types::STRING, unique: true, nullable: false)]
    private string $name;

    public function __construct(
        string $name
    ) {
        parent::__construct();

        $this->name      = $name;
        $this->shortUrls = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ShortUrl>
     */
    public function getShortUrls(): Collection
    {
        return $this->shortUrls;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
