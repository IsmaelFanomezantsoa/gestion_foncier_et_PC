<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230727125607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archive (id INT AUTO_INCREMENT NOT NULL, n_permis_archive VARCHAR(255) NOT NULL, date_delivrance_archive DATE NOT NULL, nom_demande_permis_archive VARCHAR(255) NOT NULL, nom_demande_alignement_archive VARCHAR(255) NOT NULL, nom_autre_dossier_archive VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenance (id INT AUTO_INCREMENT NOT NULL, terrain_titre_id INT DEFAULT NULL, terrain_cf_id INT DEFAULT NULL, parcelle_id INT DEFAULT NULL, usage_batiment_contenance VARCHAR(50) DEFAULT NULL, surface_occupe_contenance VARCHAR(255) DEFAULT NULL, nb_contenance INT DEFAULT NULL, INDEX IDX_4B2653FBD3AB20D (terrain_titre_id), INDEX IDX_4B2653FB6A08EF92 (terrain_cf_id), INDEX IDX_4B2653FB4433ED66 (parcelle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcelle (id INT AUTO_INCREMENT NOT NULL, terrain_cadastre_id INT DEFAULT NULL, proprietaire_parcelle_id INT DEFAULT NULL, n_parcelle VARCHAR(255) NOT NULL, superficie_parcelle VARCHAR(255) NOT NULL, image_parcelle VARCHAR(255) NOT NULL, INDEX IDX_C56E2CF672613B14 (terrain_cadastre_id), INDEX IDX_C56E2CF6274081C8 (proprietaire_parcelle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terrain_titre (id INT AUTO_INCREMENT NOT NULL, proprietaire_terrain_titre_id INT DEFAULT NULL, n_titre VARCHAR(255) NOT NULL, fkt VARCHAR(50) NOT NULL, zone_pudi VARCHAR(20) NOT NULL, superficie VARCHAR(255) NOT NULL, nom_terrain_titre VARCHAR(100) NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_A82E65BABBA352C (proprietaire_terrain_titre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contenance ADD CONSTRAINT FK_4B2653FBD3AB20D FOREIGN KEY (terrain_titre_id) REFERENCES terrain_titre (id)');
        $this->addSql('ALTER TABLE contenance ADD CONSTRAINT FK_4B2653FB6A08EF92 FOREIGN KEY (terrain_cf_id) REFERENCES terrain_cf (id)');
        $this->addSql('ALTER TABLE contenance ADD CONSTRAINT FK_4B2653FB4433ED66 FOREIGN KEY (parcelle_id) REFERENCES parcelle (id)');
        $this->addSql('ALTER TABLE parcelle ADD CONSTRAINT FK_C56E2CF672613B14 FOREIGN KEY (terrain_cadastre_id) REFERENCES terrain_cadastre (id)');
        $this->addSql('ALTER TABLE parcelle ADD CONSTRAINT FK_C56E2CF6274081C8 FOREIGN KEY (proprietaire_parcelle_id) REFERENCES proprietaire_parcelle (id)');
        $this->addSql('ALTER TABLE terrain_titre ADD CONSTRAINT FK_A82E65BABBA352C FOREIGN KEY (proprietaire_terrain_titre_id) REFERENCES proprietaire_terrain_titre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contenance DROP FOREIGN KEY FK_4B2653FBD3AB20D');
        $this->addSql('ALTER TABLE contenance DROP FOREIGN KEY FK_4B2653FB6A08EF92');
        $this->addSql('ALTER TABLE contenance DROP FOREIGN KEY FK_4B2653FB4433ED66');
        $this->addSql('ALTER TABLE parcelle DROP FOREIGN KEY FK_C56E2CF672613B14');
        $this->addSql('ALTER TABLE parcelle DROP FOREIGN KEY FK_C56E2CF6274081C8');
        $this->addSql('ALTER TABLE terrain_titre DROP FOREIGN KEY FK_A82E65BABBA352C');
        $this->addSql('DROP TABLE archive');
        $this->addSql('DROP TABLE contenance');
        $this->addSql('DROP TABLE parcelle');
        $this->addSql('DROP TABLE terrain_titre');
    }
}
