<?php


namespace Interview\Product\Infrastructure\Doctrine\DBAL\Query;

use Doctrine\DBAL\Connection;
use Interview\Product\Application\Query\GetProductQueryInterface;
use Interview\Product\Application\Query\ProductView;

class GetProductQuery implements GetProductQueryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getProductDetails(string $productId) : ProductView
    {
        $result = $this->connection->fetchAssociative('
            SELECT u.id, u.email FROM example_user u
            WHERE u.email = :email',
            [
                ':email' => 'email',
            ]
        );

        if (!$result) {
            throw new NotFoundException();
        }

        return new ProductView($result['id'], $result['email']);
    }
}
