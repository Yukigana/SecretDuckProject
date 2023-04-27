<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230427134922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ts_isInCommande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_produit INTEGER NOT NULL, id_user INTEGER NOT NULL, quantite INTEGER NOT NULL, CONSTRAINT FK_358CC787F7384557 FOREIGN KEY (id_produit) REFERENCES ts_produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_358CC7876B3CA4B FOREIGN KEY (id_user) REFERENCES ts_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_358CC787F7384557 ON ts_isInCommande (id_produit)');
        $this->addSql('CREATE INDEX IDX_358CC7876B3CA4B ON ts_isInCommande (id_user)');
        $this->addSql('CREATE TABLE ts_produit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE ts_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(20) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(50) NOT NULL, prenom VARCHAR(20) NOT NULL, nom VARCHAR(20) NOT NULL, date_naissance DATE NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1E690566AA08CB10 ON ts_user (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ts_isInCommande');
        $this->addSql('DROP TABLE ts_produit');
        $this->addSql('DROP TABLE ts_user');
    }
}
