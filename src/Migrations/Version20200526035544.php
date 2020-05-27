<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526035544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Load keywords, markets';
    }

    public function up(Schema $schema): void
    {
        $sql_keywords = "
            INSERT INTO keywords (keyword, region_id)
            VALUES
                ('RBA', 1),
                ('Lowe', 1),
            ('Morrison', 1),
            ('Australia', 1),
            ('Powell', 2),
            ('Williams', 2),
            ('Clarida', 2),
            ('Bowman', 2),
            ('Brainard', 2),
            ('Quarles', 2),
            ('Harker', 2),
            ('Mester', 2),
            ('Kashkari', 2),
            ('Kaplan', 2),
            ('Rosengren', 2),
            ('George', 2),
            ('Bullard', 2),
            ('Evans', 2),
            ('Strine', 2),
            ('Fed Reserve', 2),
            ('Germany', 3),
            ('France', 3),
            ('Italy', 3),
            ('ECB', 3),
            ('Lagarde', 3),
            ('UK', 4),
            ('Boris', 4),
            ('Boris Johnson', 4),
            ('Sunak', 4),
            ('Raab', 4),
            ('Michael Gove', 4);
        ";

        $sql_markets = "
            INSERT INTO markets (name, type)
            VALUES
                ('ASX200', 'Equities'),
                ('Dow30', 'Equities'),
                ('P500', 'Equities'),
                ('Spot Gold', 'Commodities'),
                ('Brent Oil', 'Commodities'),
                ('Crude Oil', 'Commodities'),
                ('EURUSD', 'FX'),
                ('GBPUSD', 'FX'),
                ('AUDUSD', 'FX'),
                ('USDJPY', 'FX'),
                ('EURJPY', 'FX'),
                ('AUDJPY', 'FX');
        ";

        $this->addSql($sql_keywords);
        $this->addSql($sql_markets);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
