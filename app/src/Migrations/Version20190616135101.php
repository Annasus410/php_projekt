<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190616135101 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, announcement_id INT NOT NULL, photo_name VARCHAR(255) NOT NULL, file VARCHAR(191) NOT NULL, INDEX IDX_876E0D9913AEA17 (announcement_id), UNIQUE INDEX UQ_photos_1 (file), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id)');
        $this->addSql('DROP TABLE photo');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, announcement_id INT NOT NULL, photo_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_14B78418913AEA17 (announcement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id)');
        $this->addSql('DROP TABLE photos');
    }
}
