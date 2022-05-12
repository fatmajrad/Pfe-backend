<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508130135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD created_at DATE NOT NULL, ADD updated_at DATE NOT NULL');
        $this->addSql('ALTER TABLE connaissance ADD created_at DATE NOT NULL, ADD updated_at DATE NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD created_at DATE NOT NULL, ADD updated_at DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE connaissance DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE reponse DROP created_at, DROP updated_at');
    }
}
