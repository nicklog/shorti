<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;

final class Version20210526182439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Setup';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            <<<'SQL'
                CREATE TABLE domain 
                (
                    id INT UNSIGNED AUTO_INCREMENT NOT NULL, 
                    name VARCHAR(255) NOT NULL, 
                    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT '(DC2Type:datetimeutc)', 
                    updated DATETIME DEFAULT NULL COMMENT '(DC2Type:datetimeutc)', 
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
            SQL
        );

        $this->addSql(
            <<<'SQL'
                CREATE TABLE user 
                (
                    id INT UNSIGNED AUTO_INCREMENT NOT NULL, 
                    email VARCHAR(255) NOT NULL, 
                    password VARCHAR(255) DEFAULT NULL, 
                    enable TINYINT(1) DEFAULT 1 NOT NULL, 
                    roles LONGTEXT NOT NULL COMMENT '(DC2Type:json)', 
                    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT '(DC2Type:datetimeutc)', 
                    updated DATETIME DEFAULT NULL COMMENT '(DC2Type:datetimeutc)', 
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
            SQL
        );
    }
}
