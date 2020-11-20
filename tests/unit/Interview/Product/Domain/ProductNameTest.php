<?php


namespace UnitTests\Interview\Product\Domain;


use Interview\Product\Domain\ProductName;
use Interview\Product\Exception\Domain\InvalidProductNameException;
use PHPUnit\Framework\TestCase;

/**
 * Class ProductNameTest
 * @package UnitTests\Interview\Product\Domain
 *
 * @covers \Interview\Product\Domain\ProductName
 * @covers \Interview\Product\Exception\Domain\InvalidProductNameException
 */
class ProductNameTest extends TestCase
{
    /**
     * @param string $invalidName
     *
     * @dataProvider invalidNameDataProvider
     */
    public function testShouldThrowExceptionForInvalidName(string $invalidName) : void
    {
        $this->expectException(InvalidProductNameException::class);

        new ProductName($invalidName);
    }

    public function invalidNameDataProvider() : array
    {
        return [
            [''],
            [' '],
            ['12'],
            ['ab'],
            [' 12 ']
        ];
    }

    public function testCanCreateObjectAndCastItTostring() : void
    {
        $productName = new ProductName('someName');

        $this->assertInstanceOf(ProductName::class, $productName);
        $this->assertEquals('someName', (string) $productName);
    }
}
