<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250326160620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Initial Database for Card';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card (id INT NOT NULL, name VARCHAR(255) NOT NULL, bank VARCHAR(255) DEFAULT NULL, features JSON NOT NULL, annual_fee NUMERIC(10, 2) DEFAULT NULL, transaction_fee NUMERIC(10, 2) DEFAULT NULL, card_type VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE card');
    }
}
