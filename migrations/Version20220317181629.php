<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317181629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD456C5646');
        $this->addSql('ALTER TABLE attachement DROP FOREIGN KEY FK_901C1961DA6A219');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1DA6A219');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP INDEX IDX_901C1961DA6A219 ON attachement');
        $this->addSql('ALTER TABLE attachement CHANGE place_id person_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attachement ADD CONSTRAINT FK_901C1961217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_901C1961217BBB47 ON attachement (person_id)');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1A05591E0');
        $this->addSql('DROP INDEX UNIQ_64C19C1A05591E0 ON category');
        $this->addSql('DROP INDEX IDX_64C19C1DA6A219 ON category');
        $this->addSql('ALTER TABLE category ADD attachement_id_id INT DEFAULT NULL, DROP attachement_id, DROP place_id');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1BCF80B10 FOREIGN KEY (attachement_id_id) REFERENCES attachement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1BCF80B10 ON category (attachement_id_id)');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD17686383B10');
        $this->addSql('DROP INDEX UNIQ_34DCD17686383B10 ON person');
        $this->addSql('ALTER TABLE person DROP avatar_id, CHANGE gender gender VARCHAR(255) NOT NULL, CHANGE is_partner is_partner TINYINT(1) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE has_places has_places TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, notice INT DEFAULT NULL, comment VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1323A575B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, city VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, postal_code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, latitude VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, longitude VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, status TINYINT(1) NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, views INT NOT NULL, INDEX IDX_741D53CD456C5646 (evaluation_id), INDEX IDX_741D53CDB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575B03A8386 FOREIGN KEY (created_by_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDB03A8386 FOREIGN KEY (created_by_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE attachement DROP FOREIGN KEY FK_901C1961217BBB47');
        $this->addSql('DROP INDEX IDX_901C1961217BBB47 ON attachement');
        $this->addSql('ALTER TABLE attachement CHANGE person_id place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attachement ADD CONSTRAINT FK_901C1961DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_901C1961DA6A219 ON attachement (place_id)');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1BCF80B10');
        $this->addSql('DROP INDEX UNIQ_64C19C1BCF80B10 ON category');
        $this->addSql('ALTER TABLE category ADD place_id INT DEFAULT NULL, CHANGE attachement_id_id attachement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1A05591E0 FOREIGN KEY (attachement_id) REFERENCES attachement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1A05591E0 ON category (attachement_id)');
        $this->addSql('CREATE INDEX IDX_64C19C1DA6A219 ON category (place_id)');
        $this->addSql('ALTER TABLE person ADD avatar_id INT DEFAULT NULL, CHANGE has_places has_places TINYINT(1) DEFAULT NULL, CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE is_partner is_partner TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17686383B10 FOREIGN KEY (avatar_id) REFERENCES attachement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34DCD17686383B10 ON person (avatar_id)');
    }
}
