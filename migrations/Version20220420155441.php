<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220420155441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachement CHANGE name name VARCHAR(255) NOT NULL, CHANGE path path VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE place DROP INDEX UNIQ_741D53CD12469DE2, ADD INDEX IDX_741D53CD12469DE2 (category_id)');
        $this->addSql('ALTER TABLE place CHANGE status status TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachement CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE path path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE place DROP INDEX IDX_741D53CD12469DE2, ADD UNIQUE INDEX UNIQ_741D53CD12469DE2 (category_id)');
        $this->addSql('ALTER TABLE place CHANGE status status TINYINT(1) DEFAULT NULL');
    }
}
