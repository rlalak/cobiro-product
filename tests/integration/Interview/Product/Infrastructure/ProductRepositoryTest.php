<?php


namespace IntegrationTests\Interview\Product\Infrastructure;


use IntegrationTests\IntegrationTestCase;
use Interview\Product\Infrastructure\Product;
use Interview\Product\Infrastructure\ProductRepository;
use Money\Currency;
use Money\Money;

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
        $product = new Product('nazwa', new Money('123', new Currency('PLN')));

        $this->repository->save($product);

        $productRawData = $this->executeQuery("SELECT name, price_amount, price_currency limit 1")->fetchOne();

        $this->assertEquals('nazwa', $productRawData['name']);
        $this->assertEquals('123', $productRawData['price_amount']);
        $this->assertEquals('PLN', $productRawData['price_currency']);
    }
}
