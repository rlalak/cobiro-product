<?php


namespace UnitTests\Interview\Product\Domain;


use Interview\Product\Domain\ProductName;
use Interview\Product\Domain\Product;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

/**
 * Class ProductTest
 * @package App\Tests\unit\Interview\Product\Domain
 *
 * @covers \Interview\Product\Domain\Product
 * @covers \Interview\Product\Exception\Domain\InvalidProductNameException
 */
class ProductTest extends TestCase
{
    protected function getSomePrice() : Money
    {
        return new Money('100', new Currency('PLN'));
    }

    protected function getSomeUuid() : UuidInterface
    {
        return $this->prophesize(UuidInterface::class) ->reveal();
    }

    protected function getSomeName() : ProductName
    {
        return $this->prophesize(ProductName::class) ->reveal();
    }

    public function testCanCreateObjectWithIdNameAndPrice() : void
    {
        $product = new Product($this->getSomeUuid(), $this->getSomeName(), $this->getSomePrice());

        $this->assertInstanceOf(Product::class, $product);
    }

    public function testGetterReturnProductId() : void
    {
        $id = $this->getSomeUuid();
        $product = new Product($id, $this->getSomeName(), $this->getSomePrice());

        $this->assertEquals($id, $product->getId());
    }

    public function testGetterReturnProductName() : void
    {
        $name = $this->getSomeName();
        $product = new Product($this->getSomeUuid(), $name, $this->getSomePrice());

        $this->assertEquals($name, $product->getName());
    }

    public function testGetterReturnProductPrice() : void
    {
        $price = $this->getSomePrice();
        $product = new Product($this->getSomeUuid(), $this->getSomeName(), $price);

        $this->assertEquals($price, $product->getPrice());
    }
}
