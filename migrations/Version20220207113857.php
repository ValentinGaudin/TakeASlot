<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207113857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slot ADD activity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE slot ADD CONSTRAINT FK_AC0E206781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_AC0E206781C06096 ON slot (activity_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slot DROP FOREIGN KEY FK_AC0E206781C06096');
        $this->addSql('DROP INDEX IDX_AC0E206781C06096 ON slot');
        $this->addSql('ALTER TABLE slot DROP activity_id');
    }
}
