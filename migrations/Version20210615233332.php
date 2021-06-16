<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210615233332 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE person 
                            (id INT AUTO_INCREMENT NOT NULL, 
                             name VARCHAR(255) NOT NULL, 
                             surname VARCHAR(255) NOT NULL, 
                             phone INT DEFAULT NULL, 
                             discr VARCHAR(255) NOT NULL,
                             PRIMARY KEY(id)) 
                             DEFAULT CHARACTER SET utf8mb4
                             COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rental 
                             (id INT AUTO_INCREMENT NOT NULL,
                             start_contract DATETIME NOT NULL, 
                             end_contract DATETIME NOT NULL, 
                             PRIMARY KEY(id)) 
                             DEFAULT CHARACTER SET utf8mb4
                             COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tenant 
                             (id INT NOT NULL, 
                             rental_id INT NOT NULL, 
                             UNIQUE INDEX UNIQ_4E59C462A7CF2329 (rental_id), 
                             PRIMARY KEY(id)) 
                             DEFAULT CHARACTER SET utf8mb4
                             COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tenant 
                             ADD CONSTRAINT FK_4E59C462A7CF2329 
                             FOREIGN KEY (rental_id) 
                             REFERENCES rental (id)');
        $this->addSql('ALTER TABLE tenant 
                             ADD CONSTRAINT FK_4E59C462BF396750 
                             FOREIGN KEY (id) 
                             REFERENCES person (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tenant DROP FOREIGN KEY FK_4E59C462BF396750');
        $this->addSql('ALTER TABLE tenant DROP FOREIGN KEY FK_4E59C462A7CF2329');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE rental');
        $this->addSql('DROP TABLE tenant');
    }
}
