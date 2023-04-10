<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407075622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sb_films');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sb_films (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(200) NOT NULL COLLATE "BINARY", annee INTEGER NOT NULL --annee de sortie
        , enstock BOOLEAN DEFAULT 1 NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite INTEGER DEFAULT NULL)');
    }
}
