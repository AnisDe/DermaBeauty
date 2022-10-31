<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210401164507 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_centre (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, email LONGTEXT NOT NULL, horaire TIME NOT NULL, description LONGTEXT NOT NULL, localisation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centre_categorie_centre (centre_id INT NOT NULL, categorie_centre_id INT NOT NULL, INDEX IDX_141850D8463CD7C3 (centre_id), INDEX IDX_141850D8EB63D8C4 (categorie_centre_id), PRIMARY KEY(centre_id, categorie_centre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, sujet_id INT NOT NULL, user_id INT NOT NULL, blog VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, INDEX IDX_852BBECD7C4D497E (sujet_id), INDEX IDX_852BBECDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reply (id INT AUTO_INCREMENT NOT NULL, forum_id INT NOT NULL, user_id INT NOT NULL, content VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, INDEX IDX_FDA8C6E029CCBAD0 (forum_id), INDEX IDX_FDA8C6E0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reply_like (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, reply_id INT NOT NULL, INDEX IDX_FCCDD585A76ED395 (user_id), INDEX IDX_FCCDD5858A0E4E7F (reply_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `signal` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, reply_id INT NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_740C95F5A76ED395 (user_id), INDEX IDX_740C95F58A0E4E7F (reply_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sujet (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE centre_categorie_centre ADD CONSTRAINT FK_141850D8463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE centre_categorie_centre ADD CONSTRAINT FK_141850D8EB63D8C4 FOREIGN KEY (categorie_centre_id) REFERENCES categorie_centre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECD7C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id)');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECDA76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E029CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E0A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE reply_like ADD CONSTRAINT FK_FCCDD585A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE reply_like ADD CONSTRAINT FK_FCCDD5858A0E4E7F FOREIGN KEY (reply_id) REFERENCES reply (id)');
        $this->addSql('ALTER TABLE `signal` ADD CONSTRAINT FK_740C95F5A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE `signal` ADD CONSTRAINT FK_740C95F58A0E4E7F FOREIGN KEY (reply_id) REFERENCES reply (id)');
        $this->addSql('ALTER TABLE user ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DA76ED395 ON commande (user_id)');
        $this->addSql('ALTER TABLE dermatologue DROP image');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centre_categorie_centre DROP FOREIGN KEY FK_141850D8EB63D8C4');
        $this->addSql('ALTER TABLE centre_categorie_centre DROP FOREIGN KEY FK_141850D8463CD7C3');
        $this->addSql('ALTER TABLE reply DROP FOREIGN KEY FK_FDA8C6E029CCBAD0');
        $this->addSql('ALTER TABLE reply_like DROP FOREIGN KEY FK_FCCDD5858A0E4E7F');
        $this->addSql('ALTER TABLE `signal` DROP FOREIGN KEY FK_740C95F58A0E4E7F');
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECD7C4D497E');
        $this->addSql('DROP TABLE categorie_centre');
        $this->addSql('DROP TABLE centre');
        $this->addSql('DROP TABLE centre_categorie_centre');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE reply');
        $this->addSql('DROP TABLE reply_like');
        $this->addSql('DROP TABLE `signal`');
        $this->addSql('DROP TABLE sujet');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('DROP INDEX IDX_6EEAA67DA76ED395 ON commande');
        $this->addSql('ALTER TABLE dermatologue ADD image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE User DROP image');
    }
}
