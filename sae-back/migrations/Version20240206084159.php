<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206084159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt ADD en_cours TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD lier_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239F7652B75 FOREIGN KEY (lier_id) REFERENCES livre (id)');
        $this->addSql('CREATE INDEX IDX_4DA239F7652B75 ON reservations (lier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239F7652B75');
        $this->addSql('DROP INDEX IDX_4DA239F7652B75 ON reservations');
        $this->addSql('ALTER TABLE reservations DROP lier_id');
        $this->addSql('ALTER TABLE emprunt DROP en_cours');
    }
}
