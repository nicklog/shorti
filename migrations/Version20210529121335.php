<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;

final class Version20210529121335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE short_url CHANGE code code VARCHAR(255) NOT NULL COLLATE `utf8mb4_bin`, CHANGE url url LONGTEXT NOT NULL');
    }
}
