<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219183716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_video_game_hour (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_4BA86C78A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_video_game_hour_video_game (user_video_game_hour_id INT NOT NULL, video_game_id INT NOT NULL, INDEX IDX_E346352F2DE6F3E2 (user_video_game_hour_id), INDEX IDX_E346352F16230A8 (video_game_id), PRIMARY KEY(user_video_game_hour_id, video_game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_video_game_hour ADD CONSTRAINT FK_4BA86C78A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_video_game_hour_video_game ADD CONSTRAINT FK_E346352F2DE6F3E2 FOREIGN KEY (user_video_game_hour_id) REFERENCES user_video_game_hour (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_video_game_hour_video_game ADD CONSTRAINT FK_E346352F16230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_video_game_hour DROP FOREIGN KEY FK_4BA86C78A76ED395');
        $this->addSql('ALTER TABLE user_video_game_hour_video_game DROP FOREIGN KEY FK_E346352F2DE6F3E2');
        $this->addSql('ALTER TABLE user_video_game_hour_video_game DROP FOREIGN KEY FK_E346352F16230A8');
        $this->addSql('DROP TABLE user_video_game_hour');
        $this->addSql('DROP TABLE user_video_game_hour_video_game');
    }
}
