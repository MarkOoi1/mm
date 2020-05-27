<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200527083804 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events_keywords DROP FOREIGN KEY FK_576B2D5D9D6A1065');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, profile VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_keywords (event_id INT NOT NULL, keywords_id INT NOT NULL, INDEX IDX_ECB35C8E71F7E88B (event_id), INDEX IDX_ECB35C8E6205D0B8 (keywords_id), PRIMARY KEY(event_id, keywords_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_keywords ADD CONSTRAINT FK_ECB35C8E71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_keywords ADD CONSTRAINT FK_ECB35C8E6205D0B8 FOREIGN KEY (keywords_id) REFERENCES keywords (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE events_keywords');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_keywords DROP FOREIGN KEY FK_ECB35C8E71F7E88B');
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, profile VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE events_keywords (events_id INT NOT NULL, keywords_id INT NOT NULL, INDEX IDX_576B2D5D6205D0B8 (keywords_id), INDEX IDX_576B2D5D9D6A1065 (events_id), PRIMARY KEY(events_id, keywords_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE events_keywords ADD CONSTRAINT FK_576B2D5D6205D0B8 FOREIGN KEY (keywords_id) REFERENCES keywords (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events_keywords ADD CONSTRAINT FK_576B2D5D9D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_keywords');
    }
}
