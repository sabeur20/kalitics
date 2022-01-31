<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130164421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scores (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, sites_id INT NOT NULL, score_date DATE NOT NULL, length_time INT NOT NULL, INDEX IDX_750375E67B3B43D (users_id), INDEX IDX_750375E7838E496 (sites_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sites (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, address VARCHAR(255) NOT NULL, start_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, registration_number VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scores ADD CONSTRAINT FK_750375E67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE scores ADD CONSTRAINT FK_750375E7838E496 FOREIGN KEY (sites_id) REFERENCES sites (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scores DROP FOREIGN KEY FK_750375E7838E496');
        $this->addSql('ALTER TABLE scores DROP FOREIGN KEY FK_750375E67B3B43D');
        $this->addSql('DROP TABLE scores');
        $this->addSql('DROP TABLE sites');
        $this->addSql('DROP TABLE users');
    }
}
