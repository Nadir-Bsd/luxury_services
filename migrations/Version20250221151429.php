<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221151429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidacy (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, candidate_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D930569DBE04EA9 (job_id), INDEX IDX_D930569D91BD8781 (candidate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569DBE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569D91BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F82576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('CREATE INDEX IDX_FBD8E0F812469DE2 ON job (category_id)');
        $this->addSql('CREATE INDEX IDX_FBD8E0F82576E0FD ON job (contract_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569DBE04EA9');
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569D91BD8781');
        $this->addSql('DROP TABLE candidacy');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F812469DE2');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F82576E0FD');
        $this->addSql('DROP INDEX IDX_FBD8E0F812469DE2 ON job');
        $this->addSql('DROP INDEX IDX_FBD8E0F82576E0FD ON job');
    }
}
