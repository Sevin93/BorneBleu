<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230628184958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D34A4A3511');
        $this->addSql('DROP INDEX UNIQ_F4DD61D34A4A3511 ON affectation');
        $this->addSql('ALTER TABLE affectation CHANGE vehicule_id vehicules_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D38D8BD7E2 FOREIGN KEY (vehicules_id) REFERENCES vehicules (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F4DD61D38D8BD7E2 ON affectation (vehicules_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D38D8BD7E2');
        $this->addSql('DROP INDEX UNIQ_F4DD61D38D8BD7E2 ON affectation');
        $this->addSql('ALTER TABLE affectation CHANGE vehicules_id vehicule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D34A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicules (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F4DD61D34A4A3511 ON affectation (vehicule_id)');
    }
}
