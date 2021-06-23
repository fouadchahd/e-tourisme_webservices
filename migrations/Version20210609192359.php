<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210609192359 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE linked_tour (id INT AUTO_INCREMENT NOT NULL, tour_id INT NOT NULL, poi_id INT NOT NULL, poi_order INT NOT NULL, INDEX IDX_BEA62C1315ED8D43 (tour_id), INDEX IDX_BEA62C137EACE855 (poi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE linked_tour ADD CONSTRAINT FK_BEA62C1315ED8D43 FOREIGN KEY (tour_id) REFERENCES tour (id)');
        $this->addSql('ALTER TABLE linked_tour ADD CONSTRAINT FK_BEA62C137EACE855 FOREIGN KEY (poi_id) REFERENCES poi (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE linked_tour DROP FOREIGN KEY FK_BEA62C1315ED8D43');
        $this->addSql('DROP TABLE linked_tour');
        $this->addSql('DROP TABLE tour');
    }
}
