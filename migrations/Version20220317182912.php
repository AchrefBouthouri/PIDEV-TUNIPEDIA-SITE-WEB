<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317182912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachement DROP FOREIGN KEY FK_901C1961217BBB47');
        $this->addSql('DROP INDEX IDX_901C1961217BBB47 ON attachement');
        $this->addSql('ALTER TABLE attachement DROP person_id');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1BCF80B10');
        $this->addSql('DROP INDEX UNIQ_64C19C1BCF80B10 ON category');
        $this->addSql('ALTER TABLE category CHANGE attachement_id_id attachement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1A05591E0 FOREIGN KEY (attachement_id) REFERENCES attachement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1A05591E0 ON category (attachement_id)');
        $this->addSql('ALTER TABLE person ADD avatar_id INT DEFAULT NULL, CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE has_places has_places TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17686383B10 FOREIGN KEY (avatar_id) REFERENCES attachement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34DCD17686383B10 ON person (avatar_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachement ADD person_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attachement ADD CONSTRAINT FK_901C1961217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_901C1961217BBB47 ON attachement (person_id)');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1A05591E0');
        $this->addSql('DROP INDEX UNIQ_64C19C1A05591E0 ON category');
        $this->addSql('ALTER TABLE category CHANGE attachement_id attachement_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1BCF80B10 FOREIGN KEY (attachement_id_id) REFERENCES attachement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1BCF80B10 ON category (attachement_id_id)');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD17686383B10');
        $this->addSql('DROP INDEX UNIQ_34DCD17686383B10 ON person');
        $this->addSql('ALTER TABLE person DROP avatar_id, CHANGE gender gender VARCHAR(255) NOT NULL, CHANGE has_places has_places TINYINT(1) NOT NULL');
    }
}
