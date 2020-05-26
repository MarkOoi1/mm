<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526004651 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, profile VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events_keywords (events_id INT NOT NULL, keywords_id INT NOT NULL, INDEX IDX_576B2D5D9D6A1065 (events_id), INDEX IDX_576B2D5D6205D0B8 (keywords_id), PRIMARY KEY(events_id, keywords_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keywords (id INT AUTO_INCREMENT NOT NULL, keyword VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE events_keywords ADD CONSTRAINT FK_576B2D5D9D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events_keywords ADD CONSTRAINT FK_576B2D5D6205D0B8 FOREIGN KEY (keywords_id) REFERENCES keywords (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events_keywords DROP FOREIGN KEY FK_576B2D5D9D6A1065');
        $this->addSql('ALTER TABLE events_keywords DROP FOREIGN KEY FK_576B2D5D6205D0B8');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE events_keywords');
        $this->addSql('DROP TABLE keywords');
    }
}
