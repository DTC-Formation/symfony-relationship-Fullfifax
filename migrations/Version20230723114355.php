<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230723114355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ADD student_uid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81C5E603A0 FOREIGN KEY (student_uid) REFERENCES student (uid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D4E6F81C5E603A0 ON address (student_uid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81C5E603A0');
        $this->addSql('DROP INDEX UNIQ_D4E6F81C5E603A0 ON address');
        $this->addSql('ALTER TABLE address DROP student_uid');
    }
}
