<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512144723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE connaissance_user (connaissance_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D09A712E68A34E8E (connaissance_id), INDEX IDX_D09A712EA76ED395 (user_id), PRIMARY KEY(connaissance_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE connaissance_user ADD CONSTRAINT FK_D09A712E68A34E8E FOREIGN KEY (connaissance_id) REFERENCES connaissance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE connaissance_user ADD CONSTRAINT FK_D09A712EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE connaissance_user ADD type boolean not null');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE connaissance_user');
    }
}
