<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809080512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts ADD content_type_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAE871AF52 FOREIGN KEY (content_type_id_id) REFERENCES content_type (id)');
        $this->addSql('CREATE INDEX IDX_885DBAFAE871AF52 ON posts (content_type_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAE871AF52');
        $this->addSql('DROP INDEX IDX_885DBAFAE871AF52 ON posts');
        $this->addSql('ALTER TABLE posts DROP content_type_id_id');
    }
}
