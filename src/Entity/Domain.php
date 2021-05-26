<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\AbstractEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DomainRepository")
 */
class Domain extends AbstractEntity
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ShortUrl", mappedBy="domain", cascade={"persist", "remove"})
     *
     * @var Collection<int, ShortUrl>
     */
    private Collection $shortUrls;

    /** @ORM\Column(type="string", nullable=false, unique=true) */
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

    /**
     * @return Collection<int, ShortUrl>
     */
    public function getShortUrls(): Collection
    {
        return $this->shortUrls;
    }
}
