<?php

declare(strict_types=1);

namespace App\Entity\Common;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Shapecode\Doctrine\DBAL\Types\DateTimeUTCType;

trait Modified
{
    #[ORM\Column(name: 'created', type: DateTimeUTCType::DATETIMEUTC, nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    protected DateTimeInterface $created;

    #[ORM\Column(name: 'updated', type: DateTimeUTCType::DATETIMEUTC, nullable: true)]
    protected ?DateTimeInterface $updated = null;

    public function getCreated(): DateTimeInterface
    {
        return $this->created;
    }

    public function setUpdated(DateTimeInterface $updated): void
    {
        $this->updated = $updated;
    }

    public function getUpdated(): ?DateTimeInterface
    {
        return $this->updated;
    }
}
