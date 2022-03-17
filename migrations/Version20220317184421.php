<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317184421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, adress VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(4) NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, notice SMALLINT DEFAULT NULL, status TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, views INT DEFAULT NULL, UNIQUE INDEX UNIQ_741D53CD12469DE2 (category_id), INDEX IDX_741D53CDB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDB03A8386 FOREIGN KEY (created_by_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE attachement ADD place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attachement ADD CONSTRAINT FK_901C1961DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_901C1961DA6A219 ON attachement (place_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachement DROP FOREIGN KEY FK_901C1961DA6A219');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP INDEX IDX_901C1961DA6A219 ON attachement');
        $this->addSql('ALTER TABLE attachement DROP place_id');
    }
}
