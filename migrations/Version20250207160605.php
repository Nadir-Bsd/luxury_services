<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207160605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidate DROP id_experience, DROP id_gender, DROP id_user, DROP id_job_category');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidate ADD id_experience BIGINT DEFAULT NULL, ADD id_gender BIGINT DEFAULT NULL, ADD id_user BIGINT NOT NULL, ADD id_job_category BIGINT DEFAULT NULL');
    }
}
