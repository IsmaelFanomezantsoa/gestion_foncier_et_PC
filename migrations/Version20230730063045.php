<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230730063045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE terrain_cf DROP FOREIGN KEY FK_9ECC02E776C50E4A');
        $this->addSql('DROP INDEX IDX_9ECC02E776C50E4A ON terrain_cf');
        $this->addSql('ALTER TABLE terrain_cf DROP proprietaire_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE terrain_cf ADD proprietaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE terrain_cf ADD CONSTRAINT FK_9ECC02E776C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire_terrain_cf (id)');
        $this->addSql('CREATE INDEX IDX_9ECC02E776C50E4A ON terrain_cf (proprietaire_id)');
    }
}
