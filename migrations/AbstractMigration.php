<?php

declare(strict_types=1);

namespace DoctrineMigrations;

abstract class AbstractMigration extends \Doctrine\Migrations\AbstractMigration
{
    public function isTransactional(): bool
    {
        return false;
    }
}
