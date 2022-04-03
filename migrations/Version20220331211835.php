<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220331211835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, intitule_question LONGTEXT NOT NULL, description_question LONGTEXT NOT NULL, image_code LONGBLOB DEFAULT NULL, fragment_code LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_sujet (question_id INT NOT NULL, sujet_id INT NOT NULL, INDEX IDX_1EF848991E27F6BF (question_id), INDEX IDX_1EF848997C4D497E (sujet_id), PRIMARY KEY(question_id, sujet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sujet (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description_sujet LONGTEXT DEFAULT NULL, image_sujet LONGBLOB DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_sujet ADD CONSTRAINT FK_1EF848991E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_sujet ADD CONSTRAINT FK_1EF848997C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_sujet DROP FOREIGN KEY FK_1EF848991E27F6BF');
        $this->addSql('ALTER TABLE question_sujet DROP FOREIGN KEY FK_1EF848997C4D497E');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_sujet');
        $this->addSql('DROP TABLE sujet');
    }
}
