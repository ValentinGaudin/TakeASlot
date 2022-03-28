<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207112301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity CHANGE description description VARCHAR(255) NOT NULL, CHANGE image image LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649299C24BB');
        $this->addSql('DROP INDEX IDX_8D93D649299C24BB ON user');
        $this->addSql('ALTER TABLE user DROP user_rdv_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity CHANGE description description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD user_rdv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649299C24BB FOREIGN KEY (user_rdv_id) REFERENCES calendar (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649299C24BB ON user (user_rdv_id)');
    }
}
