<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190518203417 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE announcement ADD categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CA21214B7 FOREIGN KEY (categories_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_4DB9D91CA21214B7 ON announcement (categories_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CA21214B7');
        $this->addSql('DROP INDEX IDX_4DB9D91CA21214B7 ON announcement');
        $this->addSql('ALTER TABLE announcement DROP categories_id');
    }
}
//
//ALTER TABLE `17_sus`.`announcement`
//ADD CONSTRAINT `fk_announcement_1`
//  FOREIGN KEY (`id`)
//  REFERENCES `17_sus`.`category` (`id`)
//  ON DELETE NO ACTION
//  ON UPDATE NO ACTION;
