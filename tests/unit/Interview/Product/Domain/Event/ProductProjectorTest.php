<?php


namespace UnitTests\Interview\Product\Domain\Event;


use Interview\Product\Domain\Event\ProductCreatedEvent;
use Interview\Product\Domain\Event\ProductProjector;
use Interview\Product\Domain\Event\ProductRemovedEvent;
use Interview\Product\Domain\Event\ProductUpdatedEvent;
use Interview\Product\Domain\Product;
use Interview\Product\Domain\ProductName;
use Interview\Product\Domain\ProductProjectionInterface;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

/**
 * Class ProductProjectorTest
 * @package UnitTests\Interview\Product\Domain\Event
 *
 * @covers \Interview\Product\Domain\Event\ProductProjector
 * @covers \Interview\Product\Domain\Event\ProductCreatedEvent
 * @covers \Interview\Product\Domain\Event\ProductUpdatedEvent
 */
class ProductProjectorTest extends TestCase
{
    /** @var ProductProjectionInterface */
    protected $projection;

    protected function setUp()
    {
        $this->projection = $this->prophesize(ProductProjectionInterface::class);
    }

    protected function getProjector() : ProductProjector
    {
        return new ProductProjector($this->projection->reveal());
    }

    public function testItRemoveProductFromProjectionWhenProductRemoved() : void
    {
        $uuid = $this->prophesize(UuidInterface::class);
        $uuid->__toString()->willReturn('test');
        $event = new ProductRemovedEvent($uuid->reveal());

        $this->projection->removeProduct('test')->shouldBeCalled();

        $this->getProjector()->whenProductRemoved($event);
    }

    public function testItUpdateProductInProjectionWhenProductCreated() : void
    {
        $uuid = $this->prophesize(UuidInterface::class);
        $uuid->__toString()->willReturn('test');
        $name = $this->prophesize(ProductName::class);
        $name->__toString()->willReturn('nazwa');
        $product = $this->prophesize(Product::class);
        $product->getId()->willReturn($uuid->reveal());
        $product->getName()->willReturn($name->reveal());
        $product->getPrice()->willReturn(Money::PLN(123));

        $event = new ProductCreatedEvent($product->reveal());

        $this->projection->updateProduct(
            'test',
            'nazwa',
            '123',
            'PLN'
        )->shouldBeCalled();

        $this->getProjector()->whenProductCreated($event);
    }

    public function testItUpdateProductInProjectionWhenProductUpdated() : void
    {
        $uuid = $this->prophesize(UuidInterface::class);
        $uuid->__toString()->willReturn('test');
        $name = $this->prophesize(ProductName::class);
        $name->__toString()->willReturn('nazwa');
        $product = $this->prophesize(Product::class);
        $product->getId()->willReturn($uuid->reveal());
        $product->getName()->willReturn($name->reveal());
        $product->getPrice()->willReturn(Money::PLN(123));

        $event = new ProductUpdatedEvent($product->reveal());

        $this->projection->updateProduct(
            'test',
            'nazwa',
            '123',
            'PLN'
        )->shouldBeCalled();

        $this->getProjector()->whenProductUpdated($event);
    }
}
