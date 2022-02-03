<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203140045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD activity_rdv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A1EB8DF86 FOREIGN KEY (activity_rdv_id) REFERENCES calendar (id)');
        $this->addSql('CREATE INDEX IDX_AC74095A1EB8DF86 ON activity (activity_rdv_id)');
        $this->addSql('ALTER TABLE user ADD user_rdv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649299C24BB FOREIGN KEY (user_rdv_id) REFERENCES calendar (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649299C24BB ON user (user_rdv_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A1EB8DF86');
        $this->addSql('DROP INDEX IDX_AC74095A1EB8DF86 ON activity');
        $this->addSql('ALTER TABLE activity DROP activity_rdv_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649299C24BB');
        $this->addSql('DROP INDEX IDX_8D93D649299C24BB ON user');
        $this->addSql('ALTER TABLE user DROP user_rdv_id');
    }
}
