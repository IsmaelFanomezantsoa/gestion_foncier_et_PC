<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230730094702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE terrain_cf DROP FOREIGN KEY FK_9ECC02E776C50E4A');
        $this->addSql('ALTER TABLE terrain_cf ADD CONSTRAINT FK_9ECC02E776C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire_terrain_cf (id)');
        $this->addSql('ALTER TABLE terrain_titre DROP FOREIGN KEY FK_A82E65BABBA352C');
        $this->addSql('ALTER TABLE terrain_titre ADD CONSTRAINT FK_A82E65BABBA352C FOREIGN KEY (proprietaire_terrain_titre_id) REFERENCES proprietaire_terrain_titre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE terrain_cf DROP FOREIGN KEY FK_9ECC02E776C50E4A');
        $this->addSql('ALTER TABLE terrain_cf ADD CONSTRAINT FK_9ECC02E776C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire_terrain_cf (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE terrain_titre DROP FOREIGN KEY FK_A82E65BABBA352C');
        $this->addSql('ALTER TABLE terrain_titre ADD CONSTRAINT FK_A82E65BABBA352C FOREIGN KEY (proprietaire_terrain_titre_id) REFERENCES proprietaire_terrain_titre (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
