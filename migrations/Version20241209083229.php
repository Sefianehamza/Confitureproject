<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209083229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD titre VARCHAR(255) DEFAULT NULL, DROP fruits_rouges, DROP pommes, DROP agrumes, DROP prunes, DROP pêches_abricot');
        $this->addSql('ALTER TABLE produit CHANGE category_id category_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD fruits_rouges VARCHAR(255) NOT NULL, ADD pommes VARCHAR(255) NOT NULL, ADD agrumes VARCHAR(255) NOT NULL, ADD prunes VARCHAR(255) NOT NULL, ADD pêches_abricot VARCHAR(255) NOT NULL, DROP titre');
        $this->addSql('ALTER TABLE produit CHANGE category_id category_id INT NOT NULL');
    }
}
