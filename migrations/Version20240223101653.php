<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240223101653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE park ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE park ADD CONSTRAINT FK_C4077D33A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C4077D33A76ED395 ON park (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE park DROP FOREIGN KEY FK_C4077D33A76ED395');
        $this->addSql('DROP INDEX IDX_C4077D33A76ED395 ON park');
        $this->addSql('ALTER TABLE park DROP user_id');
    }
}
