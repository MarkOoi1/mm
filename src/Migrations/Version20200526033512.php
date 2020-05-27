<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526033512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Load Region data';
    }

    public function up(Schema $schema): void
    {
        $sql = "
        INSERT INTO regions (id, name)
        VALUES
        (1, 'Australia'),
        (2, 'USA'),
        (3, 'Europe'),
        (4, 'UK');
        ";

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
