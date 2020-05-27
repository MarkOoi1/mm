<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526020536 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE regions ADD keywords_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE regions ADD CONSTRAINT FK_A26779F36205D0B8 FOREIGN KEY (keywords_id) REFERENCES keywords (id)');
        $this->addSql('CREATE INDEX IDX_A26779F36205D0B8 ON regions (keywords_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE regions DROP FOREIGN KEY FK_A26779F36205D0B8');
        $this->addSql('DROP INDEX IDX_A26779F36205D0B8 ON regions');
        $this->addSql('ALTER TABLE regions DROP keywords_id');
    }
}
