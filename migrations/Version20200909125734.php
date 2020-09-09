<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200909125734 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, gender TINYINT(1) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, birthday DATE DEFAULT NULL, phone INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, costumer_picture VARCHAR(255) DEFAULT NULL, fidelity_card TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_81398E09A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, date DATE DEFAULT NULL, time_hour TIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_FE38F8449395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, appointment_id INT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, staff_picture VARCHAR(255) DEFAULT NULL, phone INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_426EF392A76ED395 (user_id), INDEX IDX_426EF392E5B533F9 (appointment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE package (id INT AUTO_INCREMENT NOT NULL, appointment_id INT DEFAULT NULL, price INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, time TIME DEFAULT NULL, for_gender TINYINT(1) DEFAULT NULL, INDEX IDX_DE686795E5B533F9 (appointment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8449395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE staff ADD CONSTRAINT FK_426EF392A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE staff ADD CONSTRAINT FK_426EF392E5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointment (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795E5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointment (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795E5B533F9');
        $this->addSql('ALTER TABLE staff DROP FOREIGN KEY FK_426EF392E5B533F9');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8449395C3F3');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09A76ED395');
        $this->addSql('ALTER TABLE staff DROP FOREIGN KEY FK_426EF392A76ED395');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE package');
        $this->addSql('DROP TABLE staff');
        $this->addSql('DROP TABLE user');
    }
}
