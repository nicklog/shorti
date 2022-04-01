<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;

final class Version20210529113430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE short_url_domain (short_url_id INT UNSIGNED NOT NULL, domain_id INT UNSIGNED NOT NULL, INDEX IDX_D1CE922EF1252BC8 (short_url_id), INDEX IDX_D1CE922E115F0EE5 (domain_id), PRIMARY KEY(short_url_id, domain_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE short_url_domain ADD CONSTRAINT FK_D1CE922EF1252BC8 FOREIGN KEY (short_url_id) REFERENCES short_url (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE short_url_domain ADD CONSTRAINT FK_D1CE922E115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE short_url DROP FOREIGN KEY FK_83360531115F0EE5');
        $this->addSql('DROP INDEX IDX_83360531115F0EE5 ON short_url');
        $this->addSql('ALTER TABLE short_url DROP domain_id');
    }
}
