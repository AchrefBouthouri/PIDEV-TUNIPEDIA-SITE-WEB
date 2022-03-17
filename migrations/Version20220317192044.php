<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317192044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575456C5646');
        $this->addSql('DROP INDEX IDX_1323A575456C5646 ON evaluation');
        $this->addSql('ALTER TABLE evaluation CHANGE evaluation_id place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_1323A575DA6A219 ON evaluation (place_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575DA6A219');
        $this->addSql('DROP INDEX IDX_1323A575DA6A219 ON evaluation');
        $this->addSql('ALTER TABLE evaluation CHANGE place_id evaluation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575456C5646 FOREIGN KEY (evaluation_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_1323A575456C5646 ON evaluation (evaluation_id)');
    }
}
