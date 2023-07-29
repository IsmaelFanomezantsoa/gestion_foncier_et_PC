<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230727094646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE proprietaire_parcelle (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, date_naissance DATE NOT NULL, telephone VARCHAR(20) NOT NULL, adresse VARCHAR(50) NOT NULL, email VARCHAR(100) DEFAULT NULL, cin VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terrain_cadastre (id INT AUTO_INCREMENT NOT NULL, n_titre VARCHAR(255) NOT NULL, fkt VARCHAR(50) NOT NULL, zone_pudi VARCHAR(20) NOT NULL, superficie VARCHAR(255) NOT NULL, nom_cadastre VARCHAR(50) NOT NULL, image VARCHAR(255) DEFAULT NULL, nb_parcelle INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terrain_cf (id INT AUTO_INCREMENT NOT NULL, proprietaire_id INT DEFAULT NULL, n_certificat VARCHAR(255) NOT NULL, fkt VARCHAR(50) NOT NULL, zone_pudi VARCHAR(20) NOT NULL, superficie VARCHAR(255) NOT NULL, nom_terrain_cf VARCHAR(100) NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_9ECC02E776C50E4A (proprietaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE terrain_cf ADD CONSTRAINT FK_9ECC02E776C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire_terrain_cf (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE terrain_cf DROP FOREIGN KEY FK_9ECC02E776C50E4A');
        $this->addSql('DROP TABLE proprietaire_parcelle');
        $this->addSql('DROP TABLE terrain_cadastre');
        $this->addSql('DROP TABLE terrain_cf');
    }
}
