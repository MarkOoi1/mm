<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526005444 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE markets (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE markets_regions (markets_id INT NOT NULL, regions_id INT NOT NULL, INDEX IDX_5F5BFCF15FAE3715 (markets_id), INDEX IDX_5F5BFCF1FCE83E5F (regions_id), PRIMARY KEY(markets_id, regions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE markets_regions ADD CONSTRAINT FK_5F5BFCF15FAE3715 FOREIGN KEY (markets_id) REFERENCES markets (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE markets_regions ADD CONSTRAINT FK_5F5BFCF1FCE83E5F FOREIGN KEY (regions_id) REFERENCES regions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events CHANGE date date DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE markets_regions DROP FOREIGN KEY FK_5F5BFCF15FAE3715');
        $this->addSql('ALTER TABLE markets_regions DROP FOREIGN KEY FK_5F5BFCF1FCE83E5F');
        $this->addSql('DROP TABLE markets');
        $this->addSql('DROP TABLE markets_regions');
        $this->addSql('DROP TABLE regions');
        $this->addSql('ALTER TABLE events CHANGE date date DATETIME NOT NULL');
    }
}
