<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428204621 extends AbstractMigration
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
        $this->addSql('ALTER TABLE evaluation CHANGE notice notice INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place DROP INDEX UNIQ_741D53CD12469DE2, ADD INDEX IDX_741D53CD12469DE2 (category_id)');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD62BB7AEE');
        $this->addSql('DROP INDEX IDX_741D53CD62BB7AEE ON place');
        $this->addSql('ALTER TABLE place CHANGE programme_id attachement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDA05591E0 FOREIGN KEY (attachement_id) REFERENCES attachement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_741D53CDA05591E0 ON place (attachement_id)');
        $this->addSql('ALTER TABLE reclamation ADD attachement_id INT DEFAULT NULL, ADD type VARCHAR(255) NOT NULL, ADD help VARCHAR(255) NOT NULL, ADD qui VARCHAR(255) NOT NULL, ADD seul VARCHAR(255) NOT NULL, ADD contact INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A05591E0 FOREIGN KEY (attachement_id) REFERENCES attachement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE606404A05591E0 ON reclamation (attachement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachement ADD place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attachement ADD CONSTRAINT FK_901C1961DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_901C1961DA6A219 ON attachement (place_id)');
        $this->addSql('ALTER TABLE evaluation CHANGE notice notice SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE place DROP INDEX IDX_741D53CD12469DE2, ADD UNIQUE INDEX UNIQ_741D53CD12469DE2 (category_id)');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CDA05591E0');
        $this->addSql('DROP INDEX UNIQ_741D53CDA05591E0 ON place');
        $this->addSql('ALTER TABLE place CHANGE attachement_id programme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD62BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('CREATE INDEX IDX_741D53CD62BB7AEE ON place (programme_id)');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A05591E0');
        $this->addSql('DROP INDEX UNIQ_CE606404A05591E0 ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP attachement_id, DROP type, DROP help, DROP qui, DROP seul, DROP contact');
    }
}
