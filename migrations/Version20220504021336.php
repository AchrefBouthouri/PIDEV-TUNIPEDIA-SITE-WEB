<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220504021336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        
        $this->addSql('ALTER TABLE programme ADD createdby_id INT DEFAULT NULL, ADD name VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, ADD date DATE NOT NULL, ADD prix DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FFF0B5AF0B FOREIGN KEY (createdby_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_3DDCB9FFF0B5AF0B ON programme (createdby_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
      

        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FFF0B5AF0B');
        $this->addSql('DROP INDEX IDX_3DDCB9FFF0B5AF0B ON programme');
        $this->addSql('ALTER TABLE programme DROP createdby_id, DROP name, DROP description, DROP date, DROP prix');
    }
}
