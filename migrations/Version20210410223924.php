<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210410223924 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, number INT NOT NULL, zip_code INT DEFAULT NULL, sqm DOUBLE PRECISION NOT NULL, has_garden TINYINT(1) NOT NULL, location VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, floors INT DEFAULT NULL, garden_sqm INT DEFAULT NULL, accept_pets TINYINT(1) DEFAULT NULL, is_loft TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE property');
    }
}
