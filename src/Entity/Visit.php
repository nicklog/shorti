<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitRepository")
 */
class Visit extends AbstractEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ShortUrl", inversedBy="visits", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ShortUrl $shortUrl;

    /** @ORM\Column(type="text", nullable=true) */
    private ?string $referer = null;

    /** @ORM\Column(type="string", nullable=true) */
    private ?string $remoteAddr = null;

    /** @ORM\Column(type="string", nullable=true) */
    private ?string $userAgent = null;

    public function __construct(ShortUrl $domain)
    {
        parent::__construct();

        $this->shortUrl = $domain;
    }

    public function getShortUrl(): ShortUrl
    {
        return $this->shortUrl;
    }

    public function setShortUrl(ShortUrl $shortUrl): self
    {
        $this->shortUrl = $shortUrl;

        return $this;
    }

    public function getReferer(): ?string
    {
        return $this->referer;
    }

    public function setReferer(?string $referer): self
    {
        $this->referer = $referer;

        return $this;
    }

    public function getRemoteAddr(): ?string
    {
        return $this->remoteAddr;
    }

    public function setRemoteAddr(?string $remoteAddr): self
    {
        $this->remoteAddr = $remoteAddr;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function setUserAgent(?string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }
}
