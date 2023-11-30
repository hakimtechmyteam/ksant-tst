<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231130004324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE log_request ADD key VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE log_request DROP endpoint');
        $this->addSql('ALTER TABLE log_request DROP http_method');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_35AB7088A90ABA9 ON log_request (key)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_35AB7088A90ABA9');
        $this->addSql('ALTER TABLE log_request ADD http_method VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE log_request RENAME COLUMN key TO endpoint');
    }
}
