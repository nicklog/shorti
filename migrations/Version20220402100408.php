<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402100408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change date fields to utc_timestamp as default';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                ALTER TABLE visit 
                    MODIFY short_url_id INT UNSIGNED NOT NULL;
            SQL
        );
    }
}
