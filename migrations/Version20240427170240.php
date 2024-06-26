<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240427170240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vma ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE vma ADD CONSTRAINT FK_45DB89D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_45DB89D4A76ED395 ON vma (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vma DROP FOREIGN KEY FK_45DB89D4A76ED395');
        $this->addSql('DROP INDEX IDX_45DB89D4A76ED395 ON vma');
        $this->addSql('ALTER TABLE vma DROP user_id');
    }
}
