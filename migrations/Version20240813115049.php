<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240813115049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affectation (id INT AUTO_INCREMENT NOT NULL, collaborateur_id INT NOT NULL, restaurant_id INT NOT NULL, fonction_id INT DEFAULT NULL, debut DATETIME NOT NULL, fin DATETIME DEFAULT NULL, INDEX IDX_F4DD61D3A848E3B1 (collaborateur_id), INDEX IDX_F4DD61D3B1E7706E (restaurant_id), INDEX IDX_F4DD61D357889920 (fonction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collaborateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mail VARCHAR(500) NOT NULL, date_embauche DATETIME NOT NULL, `admin` TINYINT(1) NOT NULL, etat TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_NOM (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(500) NOT NULL, code_postal VARCHAR(255) NOT NULL, ville VARCHAR(500) NOT NULL, etat TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D3A848E3B1 FOREIGN KEY (collaborateur_id) REFERENCES collaborateur (id)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D3B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D357889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D3A848E3B1');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D3B1E7706E');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D357889920');
        $this->addSql('DROP TABLE affectation');
        $this->addSql('DROP TABLE collaborateur');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
