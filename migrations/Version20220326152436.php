<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220326152436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_slot (user_id INT NOT NULL, slot_id INT NOT NULL, INDEX IDX_D68F6CAEA76ED395 (user_id), INDEX IDX_D68F6CAE59E5119C (slot_id), PRIMARY KEY(user_id, slot_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_slot ADD CONSTRAINT FK_D68F6CAEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_slot ADD CONSTRAINT FK_D68F6CAE59E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_slot');
    }
}
