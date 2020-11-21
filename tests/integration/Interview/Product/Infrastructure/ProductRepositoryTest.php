<?php


namespace IntegrationTests\Interview\Product\Infrastructure;


use IntegrationTests\IntegrationTestCase;
use Interview\Product\Domain\Product;
use Interview\Product\Domain\ProductName;
use Interview\Product\Infrastructure\Doctrine\ORM\ProductRepository;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class ProductRepositoryTest
 * @package IntegrationTests\Interview\Product\Infrastructure
 *
 * @covers \Interview\Product\Infrastructure\Doctrine\ORM\ProductRepository
 */
class ProductRepositoryTest extends IntegrationTestCase
{
    protected ProductRepository $repository;

    protected function setUpTest() : void
    {
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repository = $this->get(ProductRepository::class);
    }

    public function testSaveProduct() : UuidInterface
    {
        $uuid = Uuid::uuid1();

        $product = new Product(
            $uuid,
            new ProductName('nazwa'),
            new Money('123', new Currency('PLN'))
        );

        $this->repository->save($product);

        $productRawData = $this->getProductDataById($uuid);

        $this->assertEquals((string) $uuid, $productRawData['id']);
        $this->assertEquals('nazwa', $productRawData['name']);
        $this->assertEquals('123', $productRawData['price_amount']);
        $this->assertEquals('PLN', $productRawData['price_currency']);

        return $uuid;
    }

    /**
     * @depends testSaveProduct
     */
    public function testRemoveProduct(UuidInterface $uuid) : void
    {
        $productRawData = $this->getProductDataById($uuid);

        $this->assertNotEmpty($productRawData);

        $this->repository->remove($uuid);

        $productRawData = $this->getProductDataById($uuid);

        $this->assertNull($productRawData);
    }

    protected function getProductDataById(UuidInterface $uuid) : ?array
    {
        $result = $this->executeQuery(
            "SELECT * FROM products WHERE id = :id LIMIT 1",
            ['id' => (string) $uuid]
        )->fetch();

        return $result ? $result : null;
    }
}
