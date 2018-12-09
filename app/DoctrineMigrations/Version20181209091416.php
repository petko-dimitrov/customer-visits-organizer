<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181209091416 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE addressес (id INT AUTO_INCREMENT NOT NULL, town VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, number INT DEFAULT NULL, floor INT DEFAULT NULL, apartment INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacts (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, job_title VARCHAR(255) DEFAULT NULL, INDEX IDX_334015739395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customers (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, monthly_tax NUMERIC(10, 2) NOT NULL, is_active TINYINT(1) NOT NULL, next_visit DATE DEFAULT NULL, more_info LONGTEXT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_62534E215E237E06 (name), UNIQUE INDEX UNIQ_62534E21F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expenses (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity INT NOT NULL, single_price NUMERIC(10, 2) NOT NULL, total_price NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_visits (user_id INT NOT NULL, visit_id INT NOT NULL, INDEX IDX_4BAFB77AA76ED395 (user_id), INDEX IDX_4BAFB77A75FA0FF2 (visit_id), PRIMARY KEY(user_id, visit_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visits (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, tax_collected NUMERIC(10, 2) NOT NULL, date DATE NOT NULL, is_regular TINYINT(1) NOT NULL, service_type VARCHAR(255) DEFAULT NULL, more_info VARCHAR(255) DEFAULT NULL, INDEX IDX_444839EA9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_334015739395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E21F5B7AF75 FOREIGN KEY (address_id) REFERENCES addressес (id)');
        $this->addSql('ALTER TABLE users_visits ADD CONSTRAINT FK_4BAFB77AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_visits ADD CONSTRAINT FK_4BAFB77A75FA0FF2 FOREIGN KEY (visit_id) REFERENCES visits (id)');
        $this->addSql('ALTER TABLE visits ADD CONSTRAINT FK_444839EA9395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E21F5B7AF75');
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_334015739395C3F3');
        $this->addSql('ALTER TABLE visits DROP FOREIGN KEY FK_444839EA9395C3F3');
        $this->addSql('ALTER TABLE users_visits DROP FOREIGN KEY FK_4BAFB77A75FA0FF2');
        $this->addSql('DROP TABLE addressес');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE expenses');
        $this->addSql('DROP TABLE users_visits');
        $this->addSql('DROP TABLE visits');
    }
}
