<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231015171858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_5D66EBAD5373C966 (country), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries_post (countries_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_CD291503AEBAE514 (countries_id), INDEX IDX_CD2915034B89032C (post_id), PRIMARY KEY(countries_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE countries_post ADD CONSTRAINT FK_CD291503AEBAE514 FOREIGN KEY (countries_id) REFERENCES countries (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE countries_post ADD CONSTRAINT FK_CD2915034B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE countries_post DROP FOREIGN KEY FK_CD291503AEBAE514');
        $this->addSql('ALTER TABLE countries_post DROP FOREIGN KEY FK_CD2915034B89032C');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE countries_post');
    }
}
