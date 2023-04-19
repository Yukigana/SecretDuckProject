<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230419145633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ts_commande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user INTEGER NOT NULL, date DATE DEFAULT NULL, is_finish BOOLEAN NOT NULL, CONSTRAINT FK_9E2159B56B3CA4B FOREIGN KEY (id_user) REFERENCES ts_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9E2159B56B3CA4B ON ts_commande (id_user)');
        $this->addSql('CREATE TABLE ts_commandes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, panier_id INTEGER NOT NULL, date DATE DEFAULT NULL, is_finish BOOLEAN NOT NULL, CONSTRAINT FK_A09BA951F77D927C FOREIGN KEY (panier_id) REFERENCES ts_isInCommande (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_A09BA951F77D927C ON ts_commandes (panier_id)');
        $this->addSql('CREATE TABLE ts_isInCommande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_produit INTEGER NOT NULL, id_commande INTEGER NOT NULL, quantite INTEGER NOT NULL, CONSTRAINT FK_358CC787F7384557 FOREIGN KEY (id_produit) REFERENCES ts_produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_358CC7873E314AE8 FOREIGN KEY (id_commande) REFERENCES ts_commande (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_358CC787F7384557 ON ts_isInCommande (id_produit)');
        $this->addSql('CREATE INDEX IDX_358CC7873E314AE8 ON ts_isInCommande (id_commande)');
        $this->addSql('CREATE TABLE ts_produit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE ts_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(20) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(50) NOT NULL, prenom VARCHAR(20) NOT NULL, nom VARCHAR(20) NOT NULL, date_naissance DATE NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1E690566AA08CB10 ON ts_user (login)');
        $this->addSql('CREATE TABLE ts_users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, commandes_id INTEGER NOT NULL, login VARCHAR(20) NOT NULL, mdp VARCHAR(50) NOT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, date_naissance DATE NOT NULL, is_admin BOOLEAN NOT NULL, is_super_admin BOOLEAN NOT NULL, CONSTRAINT FK_BFC162638BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES ts_commandes (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BFC162638BF5C2E6 ON ts_users (commandes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ts_commande');
        $this->addSql('DROP TABLE ts_commandes');
        $this->addSql('DROP TABLE ts_isInCommande');
        $this->addSql('DROP TABLE ts_produit');
        $this->addSql('DROP TABLE ts_user');
        $this->addSql('DROP TABLE ts_users');
    }
}
