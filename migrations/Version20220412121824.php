<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412121824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change url field to string';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                ALTER TABLE 
                    short_url MODIFY url VARCHAR(2500) NOT NULL
            SQL
        );
    }
}
