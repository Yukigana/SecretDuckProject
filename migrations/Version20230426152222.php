<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426152222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ts_commandes');
        $this->addSql('DROP TABLE ts_users');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ts_commandes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, panier_id INTEGER NOT NULL, date DATE DEFAULT NULL, is_finish BOOLEAN NOT NULL, CONSTRAINT FK_A09BA951F77D927C FOREIGN KEY (panier_id) REFERENCES ts_isInCommande (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_A09BA951F77D927C ON ts_commandes (panier_id)');
        $this->addSql('CREATE TABLE ts_users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, commandes_id INTEGER NOT NULL, login VARCHAR(20) NOT NULL COLLATE "BINARY", mdp VARCHAR(50) NOT NULL COLLATE "BINARY", nom VARCHAR(20) NOT NULL COLLATE "BINARY", prenom VARCHAR(20) NOT NULL COLLATE "BINARY", date_naissance DATE NOT NULL, is_admin BOOLEAN NOT NULL, is_super_admin BOOLEAN NOT NULL, CONSTRAINT FK_BFC162638BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES ts_commandes (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BFC162638BF5C2E6 ON ts_users (commandes_id)');
    }
}
