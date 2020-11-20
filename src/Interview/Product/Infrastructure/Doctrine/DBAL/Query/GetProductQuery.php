<?php


namespace Interview\Product\Infrastructure\Doctrine\DBAL\Query;

use Doctrine\DBAL\Connection;
use Interview\Product\Infrastructure\CreateProductViewTrait;
use Interview\Product\Application\Query\GetProductQueryInterface;
use Interview\Product\Application\Query\ProductView;
use Interview\Product\Exception\Infrastructure\ProductNotFoundException;

class GetProductQuery implements GetProductQueryInterface
{
    use CreateProductViewTrait;

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getProduct(string $id) : ProductView
    {
        $result = $this->connection->fetchAssociative(
            'SELECT * FROM products WHERE id = :id',
            [':id' => $id,]
        );

        if (!$result) {
            throw ProductNotFoundException::forIdAsString($id);
        }

        return $this->createProductViewFromArray($result);
    }

    /**
     * @return ProductView[]
     */
    public function getAlProducts() : array
    {
        $result = $this->connection->fetchAllAssociative('SELECT * FROM products');

        $productList = [];
        foreach ($result as $productData) {
            $productList[] = $this->createProductViewFromArray($productData);
        }

        return $productList;
    }
}
