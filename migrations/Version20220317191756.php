<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317191756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, evaluation_id INT DEFAULT NULL, notice SMALLINT DEFAULT NULL, comment LONGTEXT NOT NULL, created_at DATE NOT NULL, INDEX IDX_1323A575B03A8386 (created_by_id), INDEX IDX_1323A575456C5646 (evaluation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575B03A8386 FOREIGN KEY (created_by_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575456C5646 FOREIGN KEY (evaluation_id) REFERENCES place (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE evaluation');
    }
}
