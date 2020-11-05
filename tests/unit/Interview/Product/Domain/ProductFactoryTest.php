<?php


namespace App\Tests\unit\Interview\Product\Domain;


use Interview\Product\Domain\ProductFactory;
use PHPUnit\Framework\TestCase;

class ProductFactoryTest extends TestCase
{
    protected string $defaultPriceCurrency;

    protected function setUp(): void
    {
        $this->defaultPriceCurrency = 'PLN';
    }

    protected function getFactory() : ProductFactory
    {
        return new ProductFactory($this->defaultPriceCurrency);
    }

    public function testItCreateProductFromRawDataWithDefaultCurrency() : void
    {
        $this->defaultPriceCurrency = 'EUR';

        $product = $this->getFactory()->createFromRaw('abc', '12');

        $this->assertEquals('abc', $product->getName());
        $this->assertEquals('12', $product->getPrice()->getAmount());
        $this->assertEquals('EUR', $product->getPrice()->getCurrency()->getCode());
    }

    public function testItCreateProductFromRawDataWithGivenCurrency() : void
    {
        $this->defaultPriceCurrency = 'EUR';

        $product = $this->getFactory()->createFromRaw('xyz', '21', 'USD');

        $this->assertEquals('xyz', $product->getName());
        $this->assertEquals('21', $product->getPrice()->getAmount());
        $this->assertEquals('USD', $product->getPrice()->getCurrency()->getCode());
    }
}
