<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220418234501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachement DROP FOREIGN KEY FK_901C1961DA6A219');
        $this->addSql('DROP INDEX IDX_901C1961DA6A219 ON attachement');
        $this->addSql('ALTER TABLE attachement DROP place_id');
        $this->addSql('ALTER TABLE person CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE place ADD attachement_id INT DEFAULT NULL, CHANGE status status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDA05591E0 FOREIGN KEY (attachement_id) REFERENCES attachement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_741D53CDA05591E0 ON place (attachement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachement ADD place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attachement ADD CONSTRAINT FK_901C1961DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_901C1961DA6A219 ON attachement (place_id)');
        $this->addSql('ALTER TABLE person CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CDA05591E0');
        $this->addSql('DROP INDEX UNIQ_741D53CDA05591E0 ON place');
        $this->addSql('ALTER TABLE place DROP attachement_id, CHANGE status status TINYINT(1) DEFAULT NULL');
    }
}
