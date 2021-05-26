<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\AbstractEntity;
use App\Util\ShortyUtil;
use Carbon\Carbon;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Domain", inversedBy="shortUrls", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private ?Domain $domain = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visit", mappedBy="shortUrl", cascade={"persist", "remove"}, orphanRemoval=true)
     *
     * @var Collection<int, Visit>
     */
    private Collection $visits;

    /** @ORM\Column(type="string", unique=true, options={"collation": "utf8mb4_bin"}) */
    private string $code;

    /** @ORM\Column(type="text", unique=true) */
    private string $url;

    /** @ORM\Column(type="datetimeutc", nullable=false, options={"default"="CURRENT_TIMESTAMP"}) */
    private DateTimeInterface $lastUse;

    public function __construct(
        ?Domain $domain,
        string $url
    ) {
        parent::__construct();

        $this->domain  = $domain;
        $this->url     = $url;
        $this->code    = ShortyUtil::generateCode();
        $this->lastUse = Carbon::now();
        $this->visits  = new ArrayCollection();
    }

    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    public function setDomain(?Domain $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getLastUse(): DateTimeInterface
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
