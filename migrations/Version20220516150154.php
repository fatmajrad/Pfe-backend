<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516150154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_sujet (user_id INT NOT NULL, sujet_id INT NOT NULL, INDEX IDX_CCD1A2C5A76ED395 (user_id), INDEX IDX_CCD1A2C57C4D497E (sujet_id), PRIMARY KEY(user_id, sujet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_sujet ADD CONSTRAINT FK_CCD1A2C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_sujet ADD CONSTRAINT FK_CCD1A2C57C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE reponse_user');
        $this->addSql('DROP TABLE user_reponse');
        $this->addSql('ALTER TABLE user ADD description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reponse_user (reponse_id INT NOT NULL, user_id INT NOT NULL, type TINYINT(1) DEFAULT NULL, INDEX IDX_B1F89F0ACF18BB82 (reponse_id), INDEX IDX_B1F89F0AA76ED395 (user_id), PRIMARY KEY(reponse_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_reponse (user_id INT NOT NULL, reponse_id INT NOT NULL, INDEX IDX_7BBC0CDA76ED395 (user_id), INDEX IDX_7BBC0CDCF18BB82 (reponse_id), PRIMARY KEY(user_id, reponse_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reponse_user ADD CONSTRAINT FK_B1F89F0AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_user ADD CONSTRAINT FK_B1F89F0ACF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_reponse ADD CONSTRAINT FK_7BBC0CDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_reponse ADD CONSTRAINT FK_7BBC0CDCF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_sujet');
        $this->addSql('ALTER TABLE user DROP description');
    }
}
