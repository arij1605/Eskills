<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211209230036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, prenom VARCHAR(180) NOT NULL, nom VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E9A625945B (prenom), UNIQUE INDEX UNIQ_1483A5E96C6E55B5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE resetpasswordrequest');
        $this->addSql('ALTER TABLE commentaire ADD id_user INT DEFAULT NULL, ADD id_evenement INT DEFAULT NULL, ADD commentaire VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC6B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC8B13D439 FOREIGN KEY (id_evenement) REFERENCES evenement (id_event)');
        $this->addSql('CREATE INDEX id_evenement ON commentaire (id_evenement)');
        $this->addSql('CREATE INDEX id_user ON commentaire (id_user)');
        $this->addSql('ALTER TABLE cours CHANGE formation_id formation_id INT DEFAULT NULL, CHANGE nomcours nomcours VARCHAR(255) DEFAULT \'NULL\', CHANGE descriptioncours descriptioncours VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE evenement DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE evenement ADD titre VARCHAR(255) NOT NULL, ADD lieu VARCHAR(255) NOT NULL, ADD date_deb DATE NOT NULL, ADD date_fin DATE NOT NULL, ADD description VARCHAR(255) NOT NULL, ADD image_name VARCHAR(255) NOT NULL, CHANGE idevent id_event INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD PRIMARY KEY (id_event)');
        $this->addSql('ALTER TABLE examen DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE examen ADD module VARCHAR(255) NOT NULL, ADD dateex DATE NOT NULL, ADD examen VARCHAR(255) NOT NULL, ADD correction VARCHAR(255) NOT NULL, ADD etat VARCHAR(255) NOT NULL, CHANGE idexamen id_examen INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE examen ADD PRIMARY KEY (id_examen)');
        $this->addSql('ALTER TABLE favoris ADD id_evenement INT DEFAULT NULL, ADD id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4328B13D439 FOREIGN KEY (id_evenement) REFERENCES evenement (id_event)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4326B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('CREATE INDEX id_evenement ON favoris (id_evenement)');
        $this->addSql('CREATE INDEX id_user ON favoris (id_user)');
        $this->addSql('ALTER TABLE note DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE note ADD id_user INT DEFAULT NULL, ADD id_examen INT DEFAULT NULL, ADD note DOUBLE PRECISION NOT NULL, CHANGE idnote id_note INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA146B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14777B3A01 FOREIGN KEY (id_examen) REFERENCES examen (id_examen)');
        $this->addSql('CREATE INDEX id_examen ON note (id_examen)');
        $this->addSql('CREATE INDEX id_user ON note (id_user)');
        $this->addSql('ALTER TABLE note ADD PRIMARY KEY (id_note)');
        $this->addSql('ALTER TABLE participation ADD id_evenement INT DEFAULT NULL, ADD id_user INT DEFAULT NULL, ADD date DATE NOT NULL');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F8B13D439 FOREIGN KEY (id_evenement) REFERENCES evenement (id_event)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F6B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('CREATE INDEX id_evenement ON participation (id_evenement)');
        $this->addSql('CREATE INDEX id_user ON participation (id_user)');
        $this->addSql('ALTER TABLE question DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE question ADD id_user INT DEFAULT NULL, ADD contenu VARCHAR(255) NOT NULL, CHANGE idquestion id_question INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E6B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('CREATE INDEX id_user ON question (id_user)');
        $this->addSql('ALTER TABLE question ADD PRIMARY KEY (id_question)');
        $this->addSql('ALTER TABLE reclamtion DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE reclamtion ADD id_formation INT DEFAULT NULL, ADD id_user INT DEFAULT NULL, ADD sujet VARCHAR(255) NOT NULL, ADD objet VARCHAR(255) NOT NULL, ADD dateRec DATE NOT NULL, ADD etat VARCHAR(255) NOT NULL, CHANGE idrec id_rec INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reclamtion ADD CONSTRAINT FK_5C8EEBA1C0759D98 FOREIGN KEY (id_formation) REFERENCES formation (idformation)');
        $this->addSql('ALTER TABLE reclamtion ADD CONSTRAINT FK_5C8EEBA16B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('CREATE INDEX id_user ON reclamtion (id_user)');
        $this->addSql('CREATE INDEX id_formation ON reclamtion (id_formation)');
        $this->addSql('ALTER TABLE reclamtion ADD PRIMARY KEY (id_rec)');
        $this->addSql('ALTER TABLE reponse DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE reponse ADD id_question INT DEFAULT NULL, ADD id_user INT DEFAULT NULL, ADD reponse VARCHAR(255) NOT NULL, CHANGE idreponse id_reponse INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7E62CA5DB FOREIGN KEY (id_question) REFERENCES question (id_question)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC76B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('CREATE INDEX id_question ON reponse (id_question)');
        $this->addSql('CREATE INDEX id_user ON reponse (id_user)');
        $this->addSql('ALTER TABLE reponse ADD PRIMARY KEY (id_reponse)');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vote DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE vote ADD id_user INT DEFAULT NULL, ADD id_comment INT DEFAULT NULL, ADD type INT NOT NULL, CHANGE idvote id_vote INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085646B3CA4B FOREIGN KEY (id_user) REFERENCES users (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085644AE9FB1C FOREIGN KEY (id_comment) REFERENCES commentaire (id)');
        $this->addSql('CREATE INDEX id_comment ON vote (id_comment)');
        $this->addSql('CREATE INDEX id_user ON vote (id_user)');
        $this->addSql('ALTER TABLE vote ADD PRIMARY KEY (id_vote)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC6B3CA4B');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4326B3CA4B');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA146B3CA4B');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F6B3CA4B');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E6B3CA4B');
        $this->addSql('ALTER TABLE reclamtion DROP FOREIGN KEY FK_5C8EEBA16B3CA4B');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC76B3CA4B');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085646B3CA4B');
        $this->addSql('CREATE TABLE article (idArticle INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(idArticle)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE resetpasswordrequest (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC8B13D439');
        $this->addSql('DROP INDEX id_evenement ON commentaire');
        $this->addSql('DROP INDEX id_user ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP id_user, DROP id_evenement, DROP commentaire');
        $this->addSql('ALTER TABLE cours CHANGE formation_id formation_id INT NOT NULL, CHANGE nomcours nomcours VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE descriptioncours descriptioncours VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE evenement MODIFY id_event INT NOT NULL');
        $this->addSql('ALTER TABLE evenement DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE evenement DROP titre, DROP lieu, DROP date_deb, DROP date_fin, DROP description, DROP image_name, CHANGE id_event idEvent INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD PRIMARY KEY (idEvent)');
        $this->addSql('ALTER TABLE examen MODIFY id_examen INT NOT NULL');
        $this->addSql('ALTER TABLE examen DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE examen DROP module, DROP dateex, DROP examen, DROP correction, DROP etat, CHANGE id_examen idExamen INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE examen ADD PRIMARY KEY (idExamen)');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4328B13D439');
        $this->addSql('DROP INDEX id_evenement ON favoris');
        $this->addSql('DROP INDEX id_user ON favoris');
        $this->addSql('ALTER TABLE favoris DROP id_evenement, DROP id_user');
        $this->addSql('ALTER TABLE note MODIFY id_note INT NOT NULL');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14777B3A01');
        $this->addSql('DROP INDEX id_examen ON note');
        $this->addSql('DROP INDEX id_user ON note');
        $this->addSql('ALTER TABLE note DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE note DROP id_user, DROP id_examen, DROP note, CHANGE id_note idNote INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE note ADD PRIMARY KEY (idNote)');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F8B13D439');
        $this->addSql('DROP INDEX id_evenement ON participation');
        $this->addSql('DROP INDEX id_user ON participation');
        $this->addSql('ALTER TABLE participation DROP id_evenement, DROP id_user, DROP date');
        $this->addSql('ALTER TABLE question MODIFY id_question INT NOT NULL');
        $this->addSql('DROP INDEX id_user ON question');
        $this->addSql('ALTER TABLE question DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE question DROP id_user, DROP contenu, CHANGE id_question idQuestion INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE question ADD PRIMARY KEY (idQuestion)');
        $this->addSql('ALTER TABLE reclamtion MODIFY id_rec INT NOT NULL');
        $this->addSql('ALTER TABLE reclamtion DROP FOREIGN KEY FK_5C8EEBA1C0759D98');
        $this->addSql('DROP INDEX id_user ON reclamtion');
        $this->addSql('DROP INDEX id_formation ON reclamtion');
        $this->addSql('ALTER TABLE reclamtion DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE reclamtion DROP id_formation, DROP id_user, DROP sujet, DROP objet, DROP dateRec, DROP etat, CHANGE id_rec idRec INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reclamtion ADD PRIMARY KEY (idRec)');
        $this->addSql('ALTER TABLE reponse MODIFY id_reponse INT NOT NULL');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7E62CA5DB');
        $this->addSql('DROP INDEX id_question ON reponse');
        $this->addSql('DROP INDEX id_user ON reponse');
        $this->addSql('ALTER TABLE reponse DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE reponse DROP id_question, DROP id_user, DROP reponse, CHANGE id_reponse idReponse INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD PRIMARY KEY (idReponse)');
        $this->addSql('ALTER TABLE user DROP nom, DROP email');
        $this->addSql('ALTER TABLE vote MODIFY id_vote INT NOT NULL');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085644AE9FB1C');
        $this->addSql('DROP INDEX id_comment ON vote');
        $this->addSql('DROP INDEX id_user ON vote');
        $this->addSql('ALTER TABLE vote DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE vote DROP id_user, DROP id_comment, DROP type, CHANGE id_vote idVote INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE vote ADD PRIMARY KEY (idVote)');
    }
}
