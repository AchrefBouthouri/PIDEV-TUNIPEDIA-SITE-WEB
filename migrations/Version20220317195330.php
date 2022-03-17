<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317195330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, description LONGTEXT NOT NULL, created_at DATE NOT NULL, INDEX IDX_BF5476CAB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, montant DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_29D6873E71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, reservation_id INT DEFAULT NULL, date DATE NOT NULL, description VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_6D28840DB03A8386 (created_by_id), INDEX IDX_6D28840DB83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAB03A8386 FOREIGN KEY (created_by_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DB03A8386 FOREIGN KEY (created_by_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE payment');
    }
}
