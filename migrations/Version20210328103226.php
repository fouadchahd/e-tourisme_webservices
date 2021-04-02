<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210328103226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city ADD photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02347E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D5B02347E9E4C8C ON city (photo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B02347E9E4C8C');
        $this->addSql('DROP INDEX UNIQ_2D5B02347E9E4C8C ON city');
        $this->addSql('ALTER TABLE city DROP photo_id');
    }
}
