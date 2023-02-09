<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209165424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE developer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE franchise_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE genre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE platform_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE publisher_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE video_game_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE developer (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE franchise (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE genre (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE platform (id INT NOT NULL, name VARCHAR(255) NOT NULL, release_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE publisher (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, uuid UUID NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D17F50A6 ON "user" (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('COMMENT ON COLUMN "user".uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE video_game (id INT NOT NULL, uuid UUID NOT NULL, name VARCHAR(255) NOT NULL, release_date DATE DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24BC6C50D17F50A6 ON video_game (uuid)');
        $this->addSql('COMMENT ON COLUMN video_game.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE video_game_genre (video_game_id INT NOT NULL, genre_id INT NOT NULL, PRIMARY KEY(video_game_id, genre_id))');
        $this->addSql('CREATE INDEX IDX_31C452C116230A8 ON video_game_genre (video_game_id)');
        $this->addSql('CREATE INDEX IDX_31C452C14296D31F ON video_game_genre (genre_id)');
        $this->addSql('CREATE TABLE video_game_platform (video_game_id INT NOT NULL, platform_id INT NOT NULL, PRIMARY KEY(video_game_id, platform_id))');
        $this->addSql('CREATE INDEX IDX_996C03DD16230A8 ON video_game_platform (video_game_id)');
        $this->addSql('CREATE INDEX IDX_996C03DDFFE6496F ON video_game_platform (platform_id)');
        $this->addSql('CREATE TABLE video_game_developer (video_game_id INT NOT NULL, developer_id INT NOT NULL, PRIMARY KEY(video_game_id, developer_id))');
        $this->addSql('CREATE INDEX IDX_918F001816230A8 ON video_game_developer (video_game_id)');
        $this->addSql('CREATE INDEX IDX_918F001864DD9267 ON video_game_developer (developer_id)');
        $this->addSql('CREATE TABLE video_game_franchise (video_game_id INT NOT NULL, franchise_id INT NOT NULL, PRIMARY KEY(video_game_id, franchise_id))');
        $this->addSql('CREATE INDEX IDX_928245A816230A8 ON video_game_franchise (video_game_id)');
        $this->addSql('CREATE INDEX IDX_928245A8523CAB89 ON video_game_franchise (franchise_id)');
        $this->addSql('CREATE TABLE video_game_publisher (video_game_id INT NOT NULL, publisher_id INT NOT NULL, PRIMARY KEY(video_game_id, publisher_id))');
        $this->addSql('CREATE INDEX IDX_689C5EC416230A8 ON video_game_publisher (video_game_id)');
        $this->addSql('CREATE INDEX IDX_689C5EC440C86FCE ON video_game_publisher (publisher_id)');
        $this->addSql('ALTER TABLE video_game_genre ADD CONSTRAINT FK_31C452C116230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_genre ADD CONSTRAINT FK_31C452C14296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_platform ADD CONSTRAINT FK_996C03DD16230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_platform ADD CONSTRAINT FK_996C03DDFFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_developer ADD CONSTRAINT FK_918F001816230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_developer ADD CONSTRAINT FK_918F001864DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_franchise ADD CONSTRAINT FK_928245A816230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_franchise ADD CONSTRAINT FK_928245A8523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_publisher ADD CONSTRAINT FK_689C5EC416230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_publisher ADD CONSTRAINT FK_689C5EC440C86FCE FOREIGN KEY (publisher_id) REFERENCES publisher (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE developer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE franchise_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE genre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE platform_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE publisher_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE video_game_id_seq CASCADE');
        $this->addSql('ALTER TABLE video_game_genre DROP CONSTRAINT FK_31C452C116230A8');
        $this->addSql('ALTER TABLE video_game_genre DROP CONSTRAINT FK_31C452C14296D31F');
        $this->addSql('ALTER TABLE video_game_platform DROP CONSTRAINT FK_996C03DD16230A8');
        $this->addSql('ALTER TABLE video_game_platform DROP CONSTRAINT FK_996C03DDFFE6496F');
        $this->addSql('ALTER TABLE video_game_developer DROP CONSTRAINT FK_918F001816230A8');
        $this->addSql('ALTER TABLE video_game_developer DROP CONSTRAINT FK_918F001864DD9267');
        $this->addSql('ALTER TABLE video_game_franchise DROP CONSTRAINT FK_928245A816230A8');
        $this->addSql('ALTER TABLE video_game_franchise DROP CONSTRAINT FK_928245A8523CAB89');
        $this->addSql('ALTER TABLE video_game_publisher DROP CONSTRAINT FK_689C5EC416230A8');
        $this->addSql('ALTER TABLE video_game_publisher DROP CONSTRAINT FK_689C5EC440C86FCE');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE franchise');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE platform');
        $this->addSql('DROP TABLE publisher');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE video_game');
        $this->addSql('DROP TABLE video_game_genre');
        $this->addSql('DROP TABLE video_game_platform');
        $this->addSql('DROP TABLE video_game_developer');
        $this->addSql('DROP TABLE video_game_franchise');
        $this->addSql('DROP TABLE video_game_publisher');
    }
}
