<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181229131554 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE addressеs DROP FOREIGN KEY FK_B180FC1C9395C3F3');
        $this->addSql('DROP INDEX UNIQ_B180FC1C9395C3F3 ON addressеs');
        $this->addSql('ALTER TABLE addressеs DROP customer_id');
        $this->addSql('ALTER TABLE customers DROP next_visit');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE addressеs ADD customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE addressеs ADD CONSTRAINT FK_B180FC1C9395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B180FC1C9395C3F3 ON addressеs (customer_id)');
        $this->addSql('ALTER TABLE customers ADD next_visit DATE DEFAULT NULL');
    }
}
