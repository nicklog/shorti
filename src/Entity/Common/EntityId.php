<?php

declare(strict_types=1);

namespace App\Entity\Common;

interface EntityId
{
    public function getId(): ?int;
}
