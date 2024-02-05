<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240205105450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherent CHANGE nom nom VARCHAR(100) NOT NULL, CHANGE prenom prenom VARCHAR(100) NOT NULL, CHANGE date_naiss date_naiss DATETIME NOT NULL, CHANGE num_tel num_tel VARCHAR(20) NOT NULL, CHANGE photo photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE auteur CHANGE date_naissance date_naissance DATETIME NOT NULL, CHANGE date_deces date_deces DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE livre ADD resume LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239F7652B75');
        $this->addSql('DROP INDEX UNIQ_4DA239F7652B75 ON reservations');
        $this->addSql('ALTER TABLE reservations CHANGE lier_id livre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA23937D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4DA23937D925CB ON reservations (livre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA23937D925CB');
        $this->addSql('DROP INDEX UNIQ_4DA23937D925CB ON reservations');
        $this->addSql('ALTER TABLE reservations CHANGE livre_id lier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239F7652B75 FOREIGN KEY (lier_id) REFERENCES livre (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4DA239F7652B75 ON reservations (lier_id)');
        $this->addSql('ALTER TABLE adherent CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE date_naiss date_naiss DATE NOT NULL, CHANGE num_tel num_tel INT NOT NULL, CHANGE photo photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE livre DROP resume');
        $this->addSql('ALTER TABLE categorie CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE auteur CHANGE date_naissance date_naissance DATE NOT NULL, CHANGE date_deces date_deces DATE DEFAULT NULL');
    }
}
