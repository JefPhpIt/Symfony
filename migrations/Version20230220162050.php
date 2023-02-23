<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220162050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_video_game_hour_video_game DROP FOREIGN KEY FK_E346352F16230A8');
        $this->addSql('ALTER TABLE user_video_game_hour_video_game DROP FOREIGN KEY FK_E346352F2DE6F3E2');
        $this->addSql('DROP TABLE user_video_game_hour_video_game');
        $this->addSql('ALTER TABLE user_video_game_hour ADD video_game_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_video_game_hour ADD CONSTRAINT FK_4BA86C7816230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id)');
        $this->addSql('CREATE INDEX IDX_4BA86C7816230A8 ON user_video_game_hour (video_game_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_video_game_hour_video_game (user_video_game_hour_id INT NOT NULL, video_game_id INT NOT NULL, INDEX IDX_E346352F2DE6F3E2 (user_video_game_hour_id), INDEX IDX_E346352F16230A8 (video_game_id), PRIMARY KEY(user_video_game_hour_id, video_game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_video_game_hour_video_game ADD CONSTRAINT FK_E346352F16230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_video_game_hour_video_game ADD CONSTRAINT FK_E346352F2DE6F3E2 FOREIGN KEY (user_video_game_hour_id) REFERENCES user_video_game_hour (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_video_game_hour DROP FOREIGN KEY FK_4BA86C7816230A8');
        $this->addSql('DROP INDEX IDX_4BA86C7816230A8 ON user_video_game_hour');
        $this->addSql('ALTER TABLE user_video_game_hour DROP video_game_id');
    }
}
