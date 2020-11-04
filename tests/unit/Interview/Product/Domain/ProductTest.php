<?php


namespace App\Tests\unit\Interview\Product\Domain;


use App\Interview\Product\Domain\Exception\InvalidProductNameException;
use Interview\Product\Domain\Product;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

/**
 * Class ProductTest
 * @package App\Tests\unit\Interview\Product\Domain
 *
 * @covers \Interview\Product\Domain\Product
 * @covers \App\Interview\Product\Domain\Exception\InvalidProductNameException
 */
class ProductTest extends TestCase
{
    protected function getSomePrice() : Money
    {
        return new Money('100', new Currency('PLN'));
    }

    public function testCanCreateObjectWithNameAndPrice() : void
    {
        $product = new Product('testName', $this->getSomePrice());

        $this->assertInstanceOf(Product::class, $product);
    }

    /**
     * @param string $invalidName
     *
     * @dataProvider invalidNameDataProvider
     */
    public function testShouldThrowExceptionForInvalidName(string $invalidName) : void
    {
        $this->expectException(InvalidProductNameException::class);

        new Product($invalidName, $this->getSomePrice());
    }

    public function invalidNameDataProvider(string $invalidName) : array
    {
        return [
            [''],
            [' '],
            ['12'],
            ['ab'],
            [' 12 ']
        ];
    }

    public function testGetterReturnProductPrice() : void
    {
        $price = $this->getSomePrice();
        $product = new Product('testName', $price);

        $this->assertEquals($price, $product->getPrice());
    }

    public function testGetterReturnProductName() : void
    {
        $product = new Product('testName', $this->getSomePrice());

        $this->assertEquals('testName', $product->getName());
    }
}
