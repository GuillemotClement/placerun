<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240427202826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type_race VARCHAR(255) NOT NULL, kilometer INT NOT NULL, denivele INT NOT NULL, date DATETIME NOT NULL, picture VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, postalcode VARCHAR(255) NOT NULL, start_city VARCHAR(255) DEFAULT NULL, end_city VARCHAR(255) DEFAULT NULL, register_link VARCHAR(255) DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, chrono VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, gpx VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE race');
    }
}
