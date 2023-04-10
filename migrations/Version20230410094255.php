<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410094255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ts_commandes ADD COLUMN is_finish BOOLEAN NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__ts_commandes AS SELECT id, panier_id, date FROM ts_commandes');
        $this->addSql('DROP TABLE ts_commandes');
        $this->addSql('CREATE TABLE ts_commandes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, panier_id INTEGER NOT NULL, date DATE DEFAULT NULL, CONSTRAINT FK_A09BA951F77D927C FOREIGN KEY (panier_id) REFERENCES ts_isInCommande (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ts_commandes (id, panier_id, date) SELECT id, panier_id, date FROM __temp__ts_commandes');
        $this->addSql('DROP TABLE __temp__ts_commandes');
        $this->addSql('CREATE INDEX IDX_A09BA951F77D927C ON ts_commandes (panier_id)');
    }
}
