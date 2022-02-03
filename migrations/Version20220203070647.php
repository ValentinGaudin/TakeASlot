<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203070647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_AC74095A8486F9AC ON activity');
        $this->addSql('ALTER TABLE activity ADD road VARCHAR(255) NOT NULL, ADD town VARCHAR(255) NOT NULL, CHANGE adress_id zip INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP road, DROP town, CHANGE zip adress_id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC74095A8486F9AC ON activity (adress_id)');
    }
}
