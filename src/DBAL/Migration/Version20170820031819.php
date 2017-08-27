<?php

namespace HelpMeAbstract\DBAL\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170820031819 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comments (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', revision_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', author_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', body LONGTEXT NOT NULL, has_been_edited TINYINT(1) DEFAULT \'0\' NOT NULL, created DATETIME NOT NULL, INDEX IDX_5F9E962A1DFA7C8F (revision_id), INDEX IDX_5F9E962AF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notifications (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', recipient_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME NOT NULL, type VARCHAR(255) NOT NULL, subject_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_6000B0D3E92F8F78 (recipient_id), INDEX IDX_6000B0D323EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE revisions (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', author_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', body LONGTEXT NOT NULL, submission_identifier CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', created DATETIME NOT NULL, INDEX IDX_89B12285F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, twitter_handle VARCHAR(255) NOT NULL, github_handle VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, show_profile TINYINT(1) NOT NULL, age_range VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, primary_spoken_language VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, primary_technical_language VARCHAR(255) DEFAULT NULL, time_previously_spoken VARCHAR(255) DEFAULT NULL, auth_token VARCHAR(255) NOT NULL, auth_source VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A1DFA7C8F FOREIGN KEY (revision_id) REFERENCES revisions (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D3E92F8F78 FOREIGN KEY (recipient_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE revisions ADD CONSTRAINT FK_89B12285F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A1DFA7C8F');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AF675F31B');
        $this->addSql('ALTER TABLE notifications DROP FOREIGN KEY FK_6000B0D3E92F8F78');
        $this->addSql('ALTER TABLE revisions DROP FOREIGN KEY FK_89B12285F675F31B');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE revisions');
        $this->addSql('DROP TABLE users');
    }
}
