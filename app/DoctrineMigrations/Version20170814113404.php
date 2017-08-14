<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170814113404 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs

	$this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("CREATE TABLE trains (train_number int(11) NOT NULL AUTO_INCREMENT,train_type enum('electrical','steam') NOT NULL,train_name varchar(255) NOT NULL,build_year int(4) NOT NULL,PRIMARY KEY (`train_number`)) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;");



    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
