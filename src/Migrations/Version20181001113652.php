<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181001113652 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE employer_entity (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_sheet_entity (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, employer_id INT DEFAULT NULL, date DATETIME NOT NULL, to_date DATETIME DEFAULT NULL, INDEX IDX_784963EEA76ED395 (user_id), INDEX IDX_784963EE41CD9E7A (employer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_entity (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE time_sheet_entity ADD CONSTRAINT FK_784963EEA76ED395 FOREIGN KEY (user_id) REFERENCES user_entity (id)');
        $this->addSql('ALTER TABLE time_sheet_entity ADD CONSTRAINT FK_784963EE41CD9E7A FOREIGN KEY (employer_id) REFERENCES employer_entity (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE time_sheet_entity DROP FOREIGN KEY FK_784963EE41CD9E7A');
        $this->addSql('ALTER TABLE time_sheet_entity DROP FOREIGN KEY FK_784963EEA76ED395');
        $this->addSql('DROP TABLE employer_entity');
        $this->addSql('DROP TABLE time_sheet_entity');
        $this->addSql('DROP TABLE user_entity');
    }
}
