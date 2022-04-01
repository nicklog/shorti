<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;

final class Version20210527145514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fix wrong named property';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939115F0EE5');
        $this->addSql('DROP INDEX IDX_437EE939115F0EE5 ON visit');
        $this->addSql('ALTER TABLE visit CHANGE domain_id short_url_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939F1252BC8 FOREIGN KEY (short_url_id) REFERENCES short_url (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_437EE939F1252BC8 ON visit (short_url_id)');
    }
}
