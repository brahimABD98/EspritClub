<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220305143556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classroom ADD student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classroom ADD CONSTRAINT FK_497D309DCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('CREATE INDEX IDX_497D309DCB944F1A ON classroom (student_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classroom DROP FOREIGN KEY FK_497D309DCB944F1A');
        $this->addSql('DROP INDEX IDX_497D309DCB944F1A ON classroom');
        $this->addSql('ALTER TABLE classroom DROP student_id, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE student CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
