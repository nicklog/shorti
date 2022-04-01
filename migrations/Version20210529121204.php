<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;

final class Version20210529121204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE short_url CHANGE code code VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_bin`, CHANGE url url LONGTEXT DEFAULT NULL, CHANGE last_use last_use DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT \'(DC2Type:datetimeutc)\'');
    }
}
