<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181217132151 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_334015739395C3F3');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_334015739395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E21F5B7AF75');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E21F5B7AF75 FOREIGN KEY (address_id) REFERENCES addressеs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visits DROP FOREIGN KEY FK_444839EA9395C3F3');
        $this->addSql('ALTER TABLE visits ADD CONSTRAINT FK_444839EA9395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_334015739395C3F3');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_334015739395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E21F5B7AF75');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E21F5B7AF75 FOREIGN KEY (address_id) REFERENCES addressеs (id)');
        $this->addSql('ALTER TABLE visits DROP FOREIGN KEY FK_444839EA9395C3F3');
        $this->addSql('ALTER TABLE visits ADD CONSTRAINT FK_444839EA9395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
    }
}
