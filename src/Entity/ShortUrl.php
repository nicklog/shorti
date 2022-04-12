<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\AbstractEntity;
use App\Repository\ShortUrlRepository;
use App\Util\ShortyUtil;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Shapecode\Doctrine\DBAL\Types\DateTimeUTCType;

#[ORM\Entity(repositoryClass: ShortUrlRepository::class)]
class ShortUrl extends AbstractEntity
{
    /** @var Collection<int, Domain> */
    #[ORM\ManyToMany(targetEntity: Domain::class, inversedBy: 'shortUrls', cascade: ['persist'])]
    private Collection $domains;

    /** @var Collection<int, Visit> */
    #[ORM\OneToMany(mappedBy: 'shortUrl', targetEntity: Visit::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $visits;

    #[ORM\Column(type: Types::STRING, unique: true, nullable: false, options: ['collation' => 'utf8mb4_bin'])]
    private string $code;

    #[ORM\Column(type: Types::STRING, length: 2500, nullable: false)]
    private string $url;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => true])]
    private bool $enabled = true;

    #[ORM\Column(type: DateTimeUTCType::DATETIMEUTC, nullable: true, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?DateTimeInterface $lastUse = null;

    public function __construct(
        string $url,
        ?string $code = null,
    ) {
        parent::__construct();

        $this->code = $code ?? ShortyUtil::generateCode();
        $this->url  = $url;

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
