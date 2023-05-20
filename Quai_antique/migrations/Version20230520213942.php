<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230520213942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carte (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, titel VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_BAD4FFFD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, titel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galerie (id INT AUTO_INCREMENT NOT NULL, titel VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heure_midi (id INT AUTO_INCREMENT NOT NULL, info_table_id INT NOT NULL, heure TIME DEFAULT NULL, INDEX IDX_F1C6D832FBCA5336 (info_table_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heure_soir (id INT AUTO_INCREMENT NOT NULL, info_table_id INT NOT NULL, heure TIME DEFAULT NULL, INDEX IDX_7A46338DFBCA5336 (info_table_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaire (id INT AUTO_INCREMENT NOT NULL, day VARCHAR(255) NOT NULL, mstart_time TIME DEFAULT NULL, mend_time TIME DEFAULT NULL, sstart_time TIME DEFAULT NULL, send_time TIME DEFAULT NULL, is_open TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_table (id INT AUTO_INCREMENT NOT NULL, place_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, formule VARCHAR(255) NOT NULL, wish_day VARCHAR(255) NOT NULL, dish_formule VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, nbre_convive INT DEFAULT NULL, subgroup JSON NOT NULL, subgroup2 JSON NOT NULL, comment VARCHAR(255) DEFAULT NULL, allergie TINYINT(1) DEFAULT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nbre_convive INT NOT NULL, allergie TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carte ADD CONSTRAINT FK_BAD4FFFD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE heure_midi ADD CONSTRAINT FK_F1C6D832FBCA5336 FOREIGN KEY (info_table_id) REFERENCES info_table (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE heure_soir ADD CONSTRAINT FK_7A46338DFBCA5336 FOREIGN KEY (info_table_id) REFERENCES info_table (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte DROP FOREIGN KEY FK_BAD4FFFD12469DE2');
        $this->addSql('ALTER TABLE heure_midi DROP FOREIGN KEY FK_F1C6D832FBCA5336');
        $this->addSql('ALTER TABLE heure_soir DROP FOREIGN KEY FK_7A46338DFBCA5336');
        $this->addSql('DROP TABLE carte');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE galerie');
        $this->addSql('DROP TABLE heure_midi');
        $this->addSql('DROP TABLE heure_soir');
        $this->addSql('DROP TABLE horaire');
        $this->addSql('DROP TABLE info_table');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user');
    }
}
