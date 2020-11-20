<?php


namespace UnitTests\Interview\Product\Domain;


use Interview\Product\Domain\ProductFactory;
use Interview\Product\Exception\Domain\InvalidProductIdException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class ProductFactoryTest
 * @package UnitTests\Interview\Product\Domain
 *
 * @covers \Interview\Product\Domain\ProductFactory
 * @covers \Interview\Product\Exception\Domain\InvalidProductIdException
 */
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

        $product = $this->getFactory()->createFromRaw(Uuid::uuid1(), 'abc', '12');

        $this->assertEquals('abc', $product->getName());
        $this->assertEquals('12', $product->getPrice()->getAmount());
        $this->assertEquals('EUR', $product->getPrice()->getCurrency()->getCode());
    }

    public function testItCreateProductFromRawDataWithGivenCurrency() : void
    {
        $product = $this->getFactory()->createFromRaw(Uuid::uuid1(), 'xyz', '21', 'USD');

        $this->assertEquals('xyz', $product->getName());
        $this->assertEquals('21', $product->getPrice()->getAmount());
        $this->assertEquals('USD', $product->getPrice()->getCurrency()->getCode());
    }

    public function testItThrowExceptionForInvalidIdFormat()
    {
        $this->expectException(InvalidProductIdException::class);

        $this->getFactory()->createFromRaw('non-uuid', 'xyz', '21', 'USD');
    }
}
