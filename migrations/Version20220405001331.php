<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220405001331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE connaissance_sujet (connaissance_id INT NOT NULL, sujet_id INT NOT NULL, INDEX IDX_FD98A4C168A34E8E (connaissance_id), INDEX IDX_FD98A4C17C4D497E (sujet_id), PRIMARY KEY(connaissance_id, sujet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE connaissance_sujet ADD CONSTRAINT FK_FD98A4C168A34E8E FOREIGN KEY (connaissance_id) REFERENCES connaissance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE connaissance_sujet ADD CONSTRAINT FK_FD98A4C17C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE connaissance_sujet');
    }
}
