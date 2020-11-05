<?php


namespace UnitTests\Interview\Product\Application;


use App\Interview\Product\Exception\Application\InsufficientProductDataException;
use Interview\Product\Application\CreateProductCommand;
use Interview\Product\Application\CreateProductHandler;
use Interview\Product\Domain\Product;
use Interview\Product\Domain\ProductFactoryInterface;
use Interview\Product\Domain\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * Class CreateProductHandlerTest
 * @package App\Tests\unit\Interview\Product\Application
 *
 * @covers \Interview\Product\Application\CreateProductHandler
 * @covers \Interview\Product\Application\CreateProductCommand
 * @covers \App\Interview\Product\Exception\Application\InsufficientProductDataException
 */
class CreateProductHandlerTest extends TestCase
{
    /** @var ProductFactoryInterface */
    protected $productFactory;
    /** @var ProductRepositoryInterface */
    protected $productRepository;

    protected function setUp() : void
    {
        $this->productFactory = $this->prophesize(ProductFactoryInterface::class);
        $this->productFactory->createFromRaw(
            Argument::type('string'),
            Argument::type('string'),
            Argument::any()
        )->willReturn($this->prophesize(Product::class));

        $this->productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $this->productRepository->save(Argument::type(Product::class))->will(
            static function () {
            }
        );
    }

    protected function getHandler() : CreateProductHandler
    {
        return new CreateProductHandler($this->productFactory->reveal(), $this->productRepository->reveal());
    }

    public function testThrowExceptionIfCommandHasNoName() : void
    {
        $this->expectException(InsufficientProductDataException::class);

        $this->getHandler()->handle(new CreateProductCommand());
    }

    public function testThrowExceptionIfCommandHasNoPriceAmount() : void
    {
        $command = new CreateProductCommand();
        $command->name = '';

        $this->expectException(InsufficientProductDataException::class);

        $this->getHandler()->handle($command);
    }

    public function testItCreateAndSaveNewProduct() : void
    {
        $command = new CreateProductCommand();
        $command->name = 'x';
        $command->priceAmount = 'y';
        $command->priceCurrency = 'z';

        $product = $this->prophesize(Product::class)->reveal();
        $this->productFactory->createFromRaw('x', 'y', 'z')->willReturn($product);
        $this->productRepository->save($product)->shouldBeCalled();

        $this->getHandler()->handle($command);
    }
}
