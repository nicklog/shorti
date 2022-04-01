<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;

final class Version20210526195113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add short url and visit table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                CREATE TABLE short_url 
                (
                    id INT UNSIGNED AUTO_INCREMENT NOT NULL,
                    domain_id INT UNSIGNED DEFAULT NULL,
                    code VARCHAR(255) NOT NULL COLLATE `utf8mb4_bin`,
                    url LONGTEXT NOT NULL,
                    last_use DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT '(DC2Type:datetimeutc)',
                    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT '(DC2Type:datetimeutc)',
                    updated DATETIME DEFAULT NULL COMMENT '(DC2Type:datetimeutc)',
                    UNIQUE INDEX UNIQ_8336053177153098 (code),
                    UNIQUE INDEX UNIQ_83360531F47645AE (url),
                    INDEX IDX_83360531115F0EE5 (domain_id),
                    CONSTRAINT FK_83360531115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE SET NULL,
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
            SQL
        );
        $this->addSql(
            <<<'SQL'
                CREATE TABLE visit 
                (
                    id INT UNSIGNED AUTO_INCREMENT NOT NULL,
                    domain_id INT UNSIGNED NOT NULL,
                    referer LONGTEXT DEFAULT NULL,
                    remote_addr VARCHAR(255) DEFAULT NULL,
                    user_agent VARCHAR(255) DEFAULT NULL,
                    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT '(DC2Type:datetimeutc)',
                    updated DATETIME DEFAULT NULL COMMENT '(DC2Type:datetimeutc)',
                    INDEX IDX_437EE939115F0EE5 (domain_id),
                    CONSTRAINT FK_437EE939115F0EE5 FOREIGN KEY (domain_id) REFERENCES short_url (id) ON DELETE CASCADE,
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
            SQL
        );
        $this->addSql(
            <<<'SQL'
                CREATE UNIQUE INDEX UNIQ_A7A91E0B5E237E06 ON domain (name)
            SQL
        );
    }
}
