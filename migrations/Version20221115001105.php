<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115001105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE course_category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE course_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE "courses_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "coursesCategories_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "courses" (id INT NOT NULL, title VARCHAR(255) NOT NULL, course_category_id INT NOT NULL, user_id INT NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "courses".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "courses".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "coursesCategories" (id INT NOT NULL, category VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "coursesCategories".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "coursesCategories".update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_category');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "courses_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "coursesCategories_id_seq" CASCADE');
        $this->addSql('CREATE SEQUENCE course_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE course_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE course (id INT NOT NULL, title VARCHAR(255) NOT NULL, course_category_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE course_category (id INT NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE "courses"');
        $this->addSql('DROP TABLE "coursesCategories"');
    }
}
