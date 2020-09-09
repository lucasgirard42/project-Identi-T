<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200909134609 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE appointment_package');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment_package (appointment_id INT NOT NULL, package_id INT NOT NULL, INDEX IDX_4F4B55BDE5B533F9 (appointment_id), INDEX IDX_4F4B55BDF44CABFF (package_id), PRIMARY KEY(appointment_id, package_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE appointment_package ADD CONSTRAINT FK_4F4B55BDE5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointment_package ADD CONSTRAINT FK_4F4B55BDF44CABFF FOREIGN KEY (package_id) REFERENCES package (id) ON DELETE CASCADE');
    }
}
