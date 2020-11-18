<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201118202754 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products ADD code CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');

        $result = $this->connection->fetchAllAssociative('SELECT id FROM products');

        foreach ($result as $oneResult) {
            $this->addSql(
                'UPDATE products SET code = :code where id = :id',
                ['id' => $oneResult['id'], 'code' => Uuid::uuid4()]
            );
        }
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B3BA5A5A77153098 ON products (code)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_B3BA5A5A77153098 ON products');
        $this->addSql('ALTER TABLE products DROP code');
    }
}
