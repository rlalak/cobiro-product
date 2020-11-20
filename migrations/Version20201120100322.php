<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201120100322 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');

        // get all records an regenerate their id
        $result = $this->connection->fetchAllAssociative('SELECT id FROM products');
        foreach ($result as $oneResult) {
            $this->addSql(
                'UPDATE products SET id = :newId where id = :id',
                ['id' => $oneResult['id'], 'newId' => Uuid::uuid4()]
            );
        }
    }

    public function down(Schema $schema) : void
    {
        // get all records an regenerate their id
        $result = $this->connection->fetchAllAssociative('SELECT id FROM products where length(id) > 1');
        $newId = 1;
        foreach ($result as $oneResult) {
            $this->addSql(
                'UPDATE products SET id = :newId where id = :id',
                ['id' => $oneResult['id'], 'newId' => $newId++]
            );
        }

        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
