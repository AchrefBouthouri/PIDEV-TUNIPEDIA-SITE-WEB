<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317194022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, place_id INT DEFAULT NULL, attachement_id INT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, description LONGTEXT NOT NULL, capacite BIGINT NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_3BAE0AA7DA6A219 (place_id), UNIQUE INDEX UNIQ_3BAE0AA7A05591E0 (attachement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, place_id INT DEFAULT NULL, text LONGTEXT NOT NULL, INDEX IDX_CE606404B03A8386 (created_by_id), INDEX IDX_CE606404DA6A219 (place_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, place_id INT DEFAULT NULL, event_id INT DEFAULT NULL, date DATE NOT NULL, validation TINYINT(1) NOT NULL, INDEX IDX_42C84955B03A8386 (created_by_id), INDEX IDX_42C84955DA6A219 (place_id), INDEX IDX_42C8495571F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A05591E0 FOREIGN KEY (attachement_id) REFERENCES attachement (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404B03A8386 FOREIGN KEY (created_by_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B03A8386 FOREIGN KEY (created_by_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495571F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495571F7E88B');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reservation');
    }
}
