<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250310070155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE beer (id INT AUTO_INCREMENT NOT NULL, style_id INT DEFAULT NULL, brewer_id INT DEFAULT NULL, external_id INT NOT NULL, name VARCHAR(255) NOT NULL, abv DOUBLE PRECISION NOT NULL, ibu DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_58F666ADBACD6074 (style_id), INDEX IDX_58F666ADBCA4F952 (brewer_id), INDEX external_id_idx (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE beer_style (id INT AUTO_INCREMENT NOT NULL, external_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX external_id_idx (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brewer (id INT AUTO_INCREMENT NOT NULL, external_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, zipcode VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX external_id_idx (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE checkin (id INT AUTO_INCREMENT NOT NULL, beer_id INT DEFAULT NULL, user_id INT DEFAULT NULL, notation DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E1631C91D0989053 (beer_id), INDEX IDX_E1631C91A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, username VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE beer ADD CONSTRAINT FK_58F666ADBACD6074 FOREIGN KEY (style_id) REFERENCES beer_style (id)');
        $this->addSql('ALTER TABLE beer ADD CONSTRAINT FK_58F666ADBCA4F952 FOREIGN KEY (brewer_id) REFERENCES brewer (id)');
        $this->addSql('ALTER TABLE checkin ADD CONSTRAINT FK_E1631C91D0989053 FOREIGN KEY (beer_id) REFERENCES beer (id)');
        $this->addSql('ALTER TABLE checkin ADD CONSTRAINT FK_E1631C91A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beer DROP FOREIGN KEY FK_58F666ADBACD6074');
        $this->addSql('ALTER TABLE beer DROP FOREIGN KEY FK_58F666ADBCA4F952');
        $this->addSql('ALTER TABLE checkin DROP FOREIGN KEY FK_E1631C91D0989053');
        $this->addSql('ALTER TABLE checkin DROP FOREIGN KEY FK_E1631C91A76ED395');
        $this->addSql('DROP TABLE beer');
        $this->addSql('DROP TABLE beer_style');
        $this->addSql('DROP TABLE brewer');
        $this->addSql('DROP TABLE checkin');
        $this->addSql('DROP TABLE user');
    }
}
