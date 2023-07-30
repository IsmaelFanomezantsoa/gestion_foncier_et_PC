<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230730063323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE terrain_titre DROP FOREIGN KEY FK_A82E65BABBA352C');
        $this->addSql('DROP INDEX IDX_A82E65BABBA352C ON terrain_titre');
        $this->addSql('ALTER TABLE terrain_titre DROP proprietaire_terrain_titre_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE terrain_titre ADD proprietaire_terrain_titre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE terrain_titre ADD CONSTRAINT FK_A82E65BABBA352C FOREIGN KEY (proprietaire_terrain_titre_id) REFERENCES proprietaire_terrain_titre (id)');
        $this->addSql('CREATE INDEX IDX_A82E65BABBA352C ON terrain_titre (proprietaire_terrain_titre_id)');
    }
}
