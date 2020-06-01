<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200601092900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $sql_keywords = "
        INSERT INTO keywords (keyword, region_id)
        VALUES
            ('AUD', 1),
            ('EUR', 3),
            ('GBP', 4),
            ('JPY', 2),
            ('USD', 2);
        ";

        $this->addSql($sql_keywords);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
