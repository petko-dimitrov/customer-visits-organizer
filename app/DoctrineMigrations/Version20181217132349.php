<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181217132349 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users_visits DROP FOREIGN KEY FK_4BAFB77A75FA0FF2');
        $this->addSql('ALTER TABLE users_visits ADD CONSTRAINT FK_4BAFB77A75FA0FF2 FOREIGN KEY (visit_id) REFERENCES visits (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users_visits DROP FOREIGN KEY FK_4BAFB77A75FA0FF2');
        $this->addSql('ALTER TABLE users_visits ADD CONSTRAINT FK_4BAFB77A75FA0FF2 FOREIGN KEY (visit_id) REFERENCES visits (id)');
    }
}
