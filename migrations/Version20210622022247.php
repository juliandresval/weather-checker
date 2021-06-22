<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622022247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cities (id INT AUTO_INCREMENT NOT NULL, owm_id INT DEFAULT NULL, zip_code INT DEFAULT NULL, name VARCHAR(127) NOT NULL, findname VARCHAR(127) DEFAULT NULL, state VARCHAR(3) DEFAULT NULL, country VARCHAR(3) NOT NULL, lat NUMERIC(10, 7) DEFAULT NULL, lon NUMERIC(10, 7) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, date DATE DEFAULT NULL, temp DOUBLE PRECISION DEFAULT NULL, hum DOUBLE PRECISION DEFAULT NULL, INDEX history_cities_id_fk (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704B8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704B8BAC62AF');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE history');
    }
}
