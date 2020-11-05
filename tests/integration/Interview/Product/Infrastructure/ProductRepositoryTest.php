<?php


namespace IntegrationTests\Interview\Product\Infrastructure;


use IntegrationTests\IntegrationTestCase;
use Interview\Product\Domain\Product as DomainProduct;
use Interview\Product\Exception\Infrastructure\InvalidObjectToSaveException;
use Interview\Product\Infrastructure\Product;
use Interview\Product\Infrastructure\ProductRepository;
use Money\Currency;
use Money\Money;

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

    public function testThrowExceptionIfTryToSaveNonInfrastructureObject() : void
    {
        $product = new DomainProduct('nazwa', new Money('123', new Currency('PLN')));

        $this->expectException(InvalidObjectToSaveException::class);

        $this->repository->save($product);
    }

    public function testSaveProduct() : void
    {
        $product = new Product('nazwa', new Money('123', new Currency('PLN')));

        $this->repository->save($product);

        $productRawData = $this->executeQuery("SELECT name, price_amount, price_currency limit 1")->fetchOne();

        $this->assertEquals('nazwa', $productRawData['name']);
        $this->assertEquals('123', $productRawData['price_amount']);
        $this->assertEquals('PLN', $productRawData['price_currency']);
    }
}
