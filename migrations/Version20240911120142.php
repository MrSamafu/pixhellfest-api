<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240911120142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accessories (id INT AUTO_INCREMENT NOT NULL, console_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_210A264072F9DD9F (console_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consoles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, release_date DATETIME NOT NULL, creator VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_type_games (game_type_id INT NOT NULL, games_id INT NOT NULL, INDEX IDX_1FF36B2B508EF3BC (game_type_id), INDEX IDX_1FF36B2B97FFC673 (games_id), PRIMARY KEY(game_type_id, games_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE games (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, published_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accessories ADD CONSTRAINT FK_210A264072F9DD9F FOREIGN KEY (console_id) REFERENCES consoles (id)');
        $this->addSql('ALTER TABLE game_type_games ADD CONSTRAINT FK_1FF36B2B508EF3BC FOREIGN KEY (game_type_id) REFERENCES game_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_type_games ADD CONSTRAINT FK_1FF36B2B97FFC673 FOREIGN KEY (games_id) REFERENCES games (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accessories DROP FOREIGN KEY FK_210A264072F9DD9F');
        $this->addSql('ALTER TABLE game_type_games DROP FOREIGN KEY FK_1FF36B2B508EF3BC');
        $this->addSql('ALTER TABLE game_type_games DROP FOREIGN KEY FK_1FF36B2B97FFC673');
        $this->addSql('DROP TABLE accessories');
        $this->addSql('DROP TABLE consoles');
        $this->addSql('DROP TABLE game_type');
        $this->addSql('DROP TABLE game_type_games');
        $this->addSql('DROP TABLE games');
        $this->addSql('DROP TABLE user');
    }
}
