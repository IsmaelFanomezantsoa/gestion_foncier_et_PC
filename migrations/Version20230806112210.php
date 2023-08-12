<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230806112210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contenance DROP FOREIGN KEY FK_4B2653FB4433ED66');
        $this->addSql('ALTER TABLE contenance DROP FOREIGN KEY FK_4B2653FB6A08EF92');
        $this->addSql('ALTER TABLE contenance DROP FOREIGN KEY FK_4B2653FBD3AB20D');
        $this->addSql('ALTER TABLE contenance ADD CONSTRAINT FK_4B2653FB4433ED66 FOREIGN KEY (parcelle_id) REFERENCES parcelle (id)');
        $this->addSql('ALTER TABLE contenance ADD CONSTRAINT FK_4B2653FB6A08EF92 FOREIGN KEY (terrain_cf_id) REFERENCES terrain_cf (id)');
        $this->addSql('ALTER TABLE contenance ADD CONSTRAINT FK_4B2653FBD3AB20D FOREIGN KEY (terrain_titre_id) REFERENCES terrain_titre (id)');
        $this->addSql('ALTER TABLE parcelle DROP FOREIGN KEY FK_C56E2CF672613B14');
        $this->addSql('ALTER TABLE parcelle DROP FOREIGN KEY FK_C56E2CF6274081C8');
        $this->addSql('ALTER TABLE parcelle ADD CONSTRAINT FK_C56E2CF672613B14 FOREIGN KEY (terrain_cadastre_id) REFERENCES terrain_cadastre (id)');
        $this->addSql('ALTER TABLE parcelle ADD CONSTRAINT FK_C56E2CF6274081C8 FOREIGN KEY (proprietaire_parcelle_id) REFERENCES proprietaire_parcelle (id)');
        $this->addSql('ALTER TABLE terrain_cf DROP FOREIGN KEY FK_9ECC02E776C50E4A');
        $this->addSql('ALTER TABLE terrain_cf ADD CONSTRAINT FK_9ECC02E776C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire_terrain_cf (id)');
        $this->addSql('ALTER TABLE terrain_titre DROP FOREIGN KEY FK_A82E65BABBA352C');
        $this->addSql('ALTER TABLE terrain_titre ADD CONSTRAINT FK_A82E65BABBA352C FOREIGN KEY (proprietaire_terrain_titre_id) REFERENCES proprietaire_terrain_titre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contenance DROP FOREIGN KEY FK_4B2653FBD3AB20D');
        $this->addSql('ALTER TABLE contenance DROP FOREIGN KEY FK_4B2653FB6A08EF92');
        $this->addSql('ALTER TABLE contenance DROP FOREIGN KEY FK_4B2653FB4433ED66');
        $this->addSql('ALTER TABLE contenance ADD CONSTRAINT FK_4B2653FBD3AB20D FOREIGN KEY (terrain_titre_id) REFERENCES terrain_titre (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contenance ADD CONSTRAINT FK_4B2653FB6A08EF92 FOREIGN KEY (terrain_cf_id) REFERENCES terrain_cf (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contenance ADD CONSTRAINT FK_4B2653FB4433ED66 FOREIGN KEY (parcelle_id) REFERENCES parcelle (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parcelle DROP FOREIGN KEY FK_C56E2CF672613B14');
        $this->addSql('ALTER TABLE parcelle DROP FOREIGN KEY FK_C56E2CF6274081C8');
        $this->addSql('ALTER TABLE parcelle ADD CONSTRAINT FK_C56E2CF672613B14 FOREIGN KEY (terrain_cadastre_id) REFERENCES terrain_cadastre (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parcelle ADD CONSTRAINT FK_C56E2CF6274081C8 FOREIGN KEY (proprietaire_parcelle_id) REFERENCES proprietaire_parcelle (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE terrain_cf DROP FOREIGN KEY FK_9ECC02E776C50E4A');
        $this->addSql('ALTER TABLE terrain_cf ADD CONSTRAINT FK_9ECC02E776C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire_terrain_cf (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE terrain_titre DROP FOREIGN KEY FK_A82E65BABBA352C');
        $this->addSql('ALTER TABLE terrain_titre ADD CONSTRAINT FK_A82E65BABBA352C FOREIGN KEY (proprietaire_terrain_titre_id) REFERENCES proprietaire_terrain_titre (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
