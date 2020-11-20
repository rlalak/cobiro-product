<?php


namespace Interview\Product\Infrastructure\Doctrine\DBAL\Query;

use Doctrine\DBAL\Connection;
use Interview\Product\Application\Query\GetProductQueryInterface;
use Interview\Product\Application\Query\ProductView;
use Interview\Product\Exception\Infrastructure\ProductNotFoundException;

class GetProductQuery implements GetProductQueryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getProduct(string $productId) : ProductView
    {
        $result = $this->connection->fetchAssociative(
            'SELECT * FROM products WHERE id = :id',
            [':id' => $productId,]
        );

        if (!$result) {
            throw ProductNotFoundException::forId($productId);
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

    protected function createProductViewFromArray(array $productData) : ProductView
    {
        $product = new ProductView();
        $product->id = $productData['id'];
        $product->name = $productData['name'];
        $product->price = $productData['price_amount'];
        $product->currency = $productData['price_currency'];

        return $product;
    }
}
