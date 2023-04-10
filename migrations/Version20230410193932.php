<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410193932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__ts_produits AS SELECT id, libelle, prix, quantite FROM ts_produits');
        $this->addSql('DROP TABLE ts_produits');
        $this->addSql('CREATE TABLE ts_produits (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite INTEGER NOT NULL)');
        $this->addSql('INSERT INTO ts_produits (id, libelle, prix, quantite) SELECT id, libelle, prix, quantite FROM __temp__ts_produits');
        $this->addSql('DROP TABLE __temp__ts_produits');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__ts_produits AS SELECT id, libelle, prix, quantite FROM ts_produits');
        $this->addSql('DROP TABLE ts_produits');
        $this->addSql('CREATE TABLE ts_produits (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, prix INTEGER NOT NULL, quantite INTEGER NOT NULL)');
        $this->addSql('INSERT INTO ts_produits (id, libelle, prix, quantite) SELECT id, libelle, prix, quantite FROM __temp__ts_produits');
        $this->addSql('DROP TABLE __temp__ts_produits');
    }
}
