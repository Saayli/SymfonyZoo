<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221216170223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, enclo_id INT NOT NULL, num_id VARCHAR(14) NOT NULL, nom VARCHAR(255) DEFAULT NULL, date_arrivee DATE NOT NULL, date_depart DATE DEFAULT NULL, proprietaire TINYINT(1) DEFAULT NULL, genre TINYINT(1) NOT NULL, espece VARCHAR(255) NOT NULL, sterelise TINYINT(1) NOT NULL, quarantaine TINYINT(1) DEFAULT NULL, INDEX IDX_6AAB231FE475AC1 (enclo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enclos (id INT AUTO_INCREMENT NOT NULL, espace_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, superficie INT NOT NULL, animaux_max INT NOT NULL, quarantaine TINYINT(1) DEFAULT NULL, INDEX IDX_8CCECB21B6885C6C (espace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE espace (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(40) NOT NULL, superficie INT NOT NULL, date_ouverture DATE DEFAULT NULL, date_fermeture DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FE475AC1 FOREIGN KEY (enclo_id) REFERENCES enclos (id)');
        $this->addSql('ALTER TABLE enclos ADD CONSTRAINT FK_8CCECB21B6885C6C FOREIGN KEY (espace_id) REFERENCES espace (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FE475AC1');
        $this->addSql('ALTER TABLE enclos DROP FOREIGN KEY FK_8CCECB21B6885C6C');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE enclos');
        $this->addSql('DROP TABLE espace');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
