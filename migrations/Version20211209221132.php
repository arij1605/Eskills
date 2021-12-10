<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211209221132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id_article INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, contenue VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, INDEX id_user (id_user), PRIMARY KEY(id_article)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, id_evenement INT DEFAULT NULL, commentaire VARCHAR(255) NOT NULL, INDEX id_evenement (id_evenement), INDEX id_user (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id_event INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, lieu VARCHAR(255) NOT NULL, date_deb DATE NOT NULL, date_fin DATE NOT NULL, description VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, PRIMARY KEY(id_event)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE examen (id_examen INT AUTO_INCREMENT NOT NULL, module VARCHAR(255) NOT NULL, dateex DATE NOT NULL, examen VARCHAR(255) NOT NULL, correction VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id_examen)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, id_evenement INT DEFAULT NULL, id_user INT DEFAULT NULL, INDEX id_evenement (id_evenement), INDEX id_user (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id_note INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, id_examen INT DEFAULT NULL, note DOUBLE PRECISION NOT NULL, INDEX id_examen (id_examen), INDEX id_user (id_user), PRIMARY KEY(id_note)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, id_evenement INT DEFAULT NULL, id_user INT DEFAULT NULL, date DATE NOT NULL, INDEX id_evenement (id_evenement), INDEX id_user (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id_question INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, INDEX id_user (id_user), PRIMARY KEY(id_question)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamtion (id_rec INT AUTO_INCREMENT NOT NULL, id_formation INT DEFAULT NULL, id_user INT DEFAULT NULL, sujet VARCHAR(255) NOT NULL, objet VARCHAR(255) NOT NULL, dateRec DATE NOT NULL, etat VARCHAR(255) NOT NULL, INDEX id_user (id_user), INDEX id_formation (id_formation), PRIMARY KEY(id_rec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id_reponse INT AUTO_INCREMENT NOT NULL, id_question INT DEFAULT NULL, id_user INT DEFAULT NULL, reponse VARCHAR(255) NOT NULL, INDEX id_question (id_question), INDEX id_user (id_user), PRIMARY KEY(id_reponse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, prenom VARCHAR(180) NOT NULL, nom VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E9A625945B (prenom), UNIQUE INDEX UNIQ_1483A5E96C6E55B5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id_vote INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, id_comment INT DEFAULT NULL, type INT NOT NULL, INDEX id_comment (id_comment), INDEX id_user (id_user), PRIMARY KEY(id_vote)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC6B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC8B13D439 FOREIGN KEY (id_evenement) REFERENCES evenement (id_event)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4328B13D439 FOREIGN KEY (id_evenement) REFERENCES evenement (id_event)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4326B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA146B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14777B3A01 FOREIGN KEY (id_examen) REFERENCES examen (id_examen)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F8B13D439 FOREIGN KEY (id_evenement) REFERENCES evenement (id_event)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F6B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E6B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reclamtion ADD CONSTRAINT FK_5C8EEBA1C0759D98 FOREIGN KEY (id_formation) REFERENCES formation (idformation)');
        $this->addSql('ALTER TABLE reclamtion ADD CONSTRAINT FK_5C8EEBA16B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7E62CA5DB FOREIGN KEY (id_question) REFERENCES question (id_question)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC76B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085646B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085644AE9FB1C FOREIGN KEY (id_comment) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE cours CHANGE formation_id formation_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085644AE9FB1C');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC8B13D439');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4328B13D439');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F8B13D439');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14777B3A01');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7E62CA5DB');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC6B3CA4B');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4326B3CA4B');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA146B3CA4B');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F6B3CA4B');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E6B3CA4B');
        $this->addSql('ALTER TABLE reclamtion DROP FOREIGN KEY FK_5C8EEBA16B3CA4B');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC76B3CA4B');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085646B3CA4B');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE examen');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE reclamtion');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE vote');
        $this->addSql('ALTER TABLE cours CHANGE formation_id formation_id INT NOT NULL');
    }
}
