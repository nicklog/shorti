<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\AbstractEntity;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShortUrlRepository")
 */
class ShortUrl extends AbstractEntity
{
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Domain", inversedBy="shortUrls", cascade={"persist"})
     *
     * @var Collection<int, Domain>
     */
    private Collection $domains;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visit", mappedBy="shortUrl", cascade={"persist", "remove"}, orphanRemoval=true)
     *
     * @var Collection<int, Visit>
     */
    private Collection $visits;

    /** @ORM\Column(type="string", unique=true, nullable=false, options={"collation": "utf8mb4_bin"}) */
    private ?string $code = null;

    /** @ORM\Column(type="text", unique=true, nullable=false) */
    private ?string $url = null;

    /** @ORM\Column(type="text", nullable=true) */
    private ?string $title = null;

    /** @ORM\Column(type="boolean", nullable=false, options={"default": true}) */
    private bool $enabled = true;

    /** @ORM\Column(type="datetimeutc", nullable=true, options={"default"="CURRENT_TIMESTAMP"}) */
    private ?DateTimeInterface $lastUse;

    public function __construct()
    {
        parent::__construct();

        $this->visits  = new ArrayCollection();
        $this->domains = new ArrayCollection();
    }

    /**
     * @return Collection<int, Domain>
     */
    public function getDomains(): Collection
    {
        return $this->domains;
    }

    /**
     * @return Collection<int, string>
     */
    public function getDomainsAsString(): Collection
    {
        return $this->domains->map(static fn (Domain $domain): string => $domain->__toString());
    }

    public function addDomain(Domain $domain): self
    {
        if ($this->domains->contains($domain)) {
            return $this;
        }

        $domain->getShortUrls()->add($this);
        $this->domains->add($domain);

        return $this;
    }

    public function removeDomain(Domain $domain): self
    {
        if (! $this->domains->contains($domain)) {
            return $this;
        }

        $domain->getShortUrls()->removeElement($this);
        $this->domains->removeElement($domain);

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function enable(): self
    {
        $this->enabled = true;

        return $this;
    }

    public function disable(): self
    {
        $this->enabled = false;

        return $this;
    }

    public function getLastUse(): ?DateTimeInterface
    {
        return $this->lastUse;
    }

    public function setLastUse(DateTimeInterface $lastUse): self
    {
        $this->lastUse = $lastUse;

        return $this;
    }

    /**
     * @return Collection<int, Visit>
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }
}
