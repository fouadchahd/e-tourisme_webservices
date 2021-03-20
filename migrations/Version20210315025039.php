<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210315025039 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, formatted_address LONGTEXT DEFAULT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, INDEX IDX_D4E6F818BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audio (id INT AUTO_INCREMENT NOT NULL, language_id INT NOT NULL, poi_id INT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_187D369582F1BAF4 (language_id), INDEX IDX_187D36957EACE855 (poi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE description (id INT AUTO_INCREMENT NOT NULL, language_id INT NOT NULL, poi_id INT NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_6DE4402682F1BAF4 (language_id), INDEX IDX_6DE440267EACE855 (poi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, language_code VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, poi_id INT NOT NULL, url VARCHAR(255) NOT NULL, alt LONGTEXT DEFAULT NULL, INDEX IDX_14B784187EACE855 (poi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poi (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, type_of_attraction_id INT NOT NULL, address_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_7DBB1FD6727ACA70 (parent_id), INDEX IDX_7DBB1FD62E81E73C (type_of_attraction_id), INDEX IDX_7DBB1FD6F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, rate SMALLINT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tourist (id INT AUTO_INCREMENT NOT NULL, profile_picture_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nationality VARCHAR(255) DEFAULT NULL, pseudo VARCHAR(255) DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, registered_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_9891FEDEE7927C74 (email), UNIQUE INDEX UNIQ_9891FEDE292E8AE2 (profile_picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_of_attraction (id INT AUTO_INCREMENT NOT NULL, parent_type_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_4CBA9018B704F8D5 (parent_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F818BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE audio ADD CONSTRAINT FK_187D369582F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE audio ADD CONSTRAINT FK_187D36957EACE855 FOREIGN KEY (poi_id) REFERENCES poi (id)');
        $this->addSql('ALTER TABLE description ADD CONSTRAINT FK_6DE4402682F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE description ADD CONSTRAINT FK_6DE440267EACE855 FOREIGN KEY (poi_id) REFERENCES poi (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784187EACE855 FOREIGN KEY (poi_id) REFERENCES poi (id)');
        $this->addSql('ALTER TABLE poi ADD CONSTRAINT FK_7DBB1FD6727ACA70 FOREIGN KEY (parent_id) REFERENCES poi (id)');
        $this->addSql('ALTER TABLE poi ADD CONSTRAINT FK_7DBB1FD62E81E73C FOREIGN KEY (type_of_attraction_id) REFERENCES type_of_attraction (id)');
        $this->addSql('ALTER TABLE poi ADD CONSTRAINT FK_7DBB1FD6F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE tourist ADD CONSTRAINT FK_9891FEDE292E8AE2 FOREIGN KEY (profile_picture_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE type_of_attraction ADD CONSTRAINT FK_4CBA9018B704F8D5 FOREIGN KEY (parent_type_id) REFERENCES type_of_attraction (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poi DROP FOREIGN KEY FK_7DBB1FD6F5B7AF75');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F818BAC62AF');
        $this->addSql('ALTER TABLE audio DROP FOREIGN KEY FK_187D369582F1BAF4');
        $this->addSql('ALTER TABLE description DROP FOREIGN KEY FK_6DE4402682F1BAF4');
        $this->addSql('ALTER TABLE tourist DROP FOREIGN KEY FK_9891FEDE292E8AE2');
        $this->addSql('ALTER TABLE audio DROP FOREIGN KEY FK_187D36957EACE855');
        $this->addSql('ALTER TABLE description DROP FOREIGN KEY FK_6DE440267EACE855');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784187EACE855');
        $this->addSql('ALTER TABLE poi DROP FOREIGN KEY FK_7DBB1FD6727ACA70');
        $this->addSql('ALTER TABLE poi DROP FOREIGN KEY FK_7DBB1FD62E81E73C');
        $this->addSql('ALTER TABLE type_of_attraction DROP FOREIGN KEY FK_4CBA9018B704F8D5');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE audio');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE description');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE poi');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE tourist');
        $this->addSql('DROP TABLE type_of_attraction');
    }
}
