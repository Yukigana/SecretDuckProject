<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428100014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__ts_isInCommande AS SELECT id, id_produit, id_user, quantite FROM ts_isInCommande');
        $this->addSql('DROP TABLE ts_isInCommande');
        $this->addSql('CREATE TABLE ts_isInCommande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_produit INTEGER NOT NULL, id_user INTEGER NOT NULL, quantite INTEGER NOT NULL, CONSTRAINT FK_358CC787F7384557 FOREIGN KEY (id_produit) REFERENCES ts_produit (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_358CC7876B3CA4B FOREIGN KEY (id_user) REFERENCES ts_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ts_isInCommande (id, id_produit, id_user, quantite) SELECT id, id_produit, id_user, quantite FROM __temp__ts_isInCommande');
        $this->addSql('DROP TABLE __temp__ts_isInCommande');
        $this->addSql('CREATE INDEX IDX_358CC7876B3CA4B ON ts_isInCommande (id_user)');
        $this->addSql('CREATE INDEX IDX_358CC787F7384557 ON ts_isInCommande (id_produit)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__ts_isInCommande AS SELECT id, id_produit, id_user, quantite FROM ts_isInCommande');
        $this->addSql('DROP TABLE ts_isInCommande');
        $this->addSql('CREATE TABLE ts_isInCommande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_produit INTEGER NOT NULL, id_user INTEGER NOT NULL, quantite INTEGER NOT NULL, CONSTRAINT FK_358CC787F7384557 FOREIGN KEY (id_produit) REFERENCES ts_produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_358CC7876B3CA4B FOREIGN KEY (id_user) REFERENCES ts_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ts_isInCommande (id, id_produit, id_user, quantite) SELECT id, id_produit, id_user, quantite FROM __temp__ts_isInCommande');
        $this->addSql('DROP TABLE __temp__ts_isInCommande');
        $this->addSql('CREATE INDEX IDX_358CC7876B3CA4B ON ts_isInCommande (id_user)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_358CC787F7384557 ON ts_isInCommande (id_produit)');
    }
}
