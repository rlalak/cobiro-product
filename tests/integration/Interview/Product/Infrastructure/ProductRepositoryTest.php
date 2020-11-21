<?php


namespace IntegrationTests\Interview\Product\Infrastructure;


use IntegrationTests\IntegrationTestCase;
use Interview\Product\Domain\Product;
use Interview\Product\Domain\ProductName;
use Interview\Product\Infrastructure\Doctrine\ORM\ProductRepository;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;

/**
 * Class ProductRepositoryTest
 * @package IntegrationTests\Interview\Product\Infrastructure
 *
 * @covers \Interview\Product\Infrastructure\ProductRepository
 * @covers \Interview\Product\Exception\Infrastructure\InvalidObjectToSaveException
 */
class ProductRepositoryTest extends IntegrationTestCase
{
    protected ProductRepository $repository;

    protected function setUpTest() : void
    {
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repository = $this->get(ProductRepository::class);
    }

    public function testSaveProduct() : void
    {
        $uuid = Uuid::uuid1();
        $product = new Product(
            $uuid,
            new ProductName('nazwa'),
            new Money('123', new Currency('PLN'))
        );

        $this->repository->save($product);

        $productRawData = $this->executeQuery("SELECT name, price_amount, price_currency limit 1")->fetchOne();

        $this->assertEquals((string) $uuid, $productRawData['id']);
        $this->assertEquals('nazwa', $productRawData['name']);
        $this->assertEquals('123', $productRawData['price_amount']);
        $this->assertEquals('PLN', $productRawData['price_currency']);
    }
}
