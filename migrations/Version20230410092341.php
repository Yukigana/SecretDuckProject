<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410092341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commandes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, panier_id INTEGER NOT NULL, date DATE DEFAULT NULL, CONSTRAINT FK_35D4282CF77D927C FOREIGN KEY (panier_id) REFERENCES is_in_commande (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_35D4282CF77D927C ON commandes (panier_id)');
        $this->addSql('CREATE TABLE is_in_commande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, produit_id INTEGER NOT NULL, CONSTRAINT FK_F875B754F347EFB FOREIGN KEY (produit_id) REFERENCES ts_produits (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F875B754F347EFB ON is_in_commande (produit_id)');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, commandes_id INTEGER NOT NULL, login VARCHAR(20) NOT NULL, mdp VARCHAR(50) NOT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, date_naissance DATE NOT NULL, is_admin BOOLEAN NOT NULL, is_super_admin BOOLEAN NOT NULL, CONSTRAINT FK_1483A5E98BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commandes (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1483A5E98BF5C2E6 ON users (commandes_id)');
        $this->addSql('ALTER TABLE ts_produits ADD COLUMN quantite INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE is_in_commande');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ts_produits AS SELECT id, libelle, prix FROM ts_produits');
        $this->addSql('DROP TABLE ts_produits');
        $this->addSql('CREATE TABLE ts_produits (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, prix INTEGER NOT NULL)');
        $this->addSql('INSERT INTO ts_produits (id, libelle, prix) SELECT id, libelle, prix FROM __temp__ts_produits');
        $this->addSql('DROP TABLE __temp__ts_produits');
    }
}
