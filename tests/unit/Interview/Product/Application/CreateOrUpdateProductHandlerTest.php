<?php


namespace UnitTests\Interview\Product\Application;


use Interview\Product\Application\Command\CreateOrUpdateProductHandler;
use Interview\Product\Application\Command\CreateProductCommand;
use Interview\Product\Application\Command\UpdateProductCommand;
use Interview\Product\Domain\Event\ProductCreatedEvent;
use Interview\Product\Domain\Event\ProductUpdatedEvent;
use Interview\Product\Domain\Product;
use Interview\Product\Domain\ProductFactoryInterface;
use Interview\Product\Domain\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class CreateProductHandlerTest
 * @package App\Tests\unit\Interview\Product\Application
 *
 * @covers \Interview\Product\Application\Command\CreateOrUpdateProductHandler
 * @covers \Interview\Product\Application\Command\CreateProductCommand
 * @covers \Interview\Product\Application\Command\UpdateProductCommand
 */
class CreateOrUpdateProductHandlerTest extends TestCase
{
    /** @var ProductFactoryInterface */
    protected $productFactory;
    /** @var ProductRepositoryInterface */
    protected $productRepository;
    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    protected function setUp() : void
    {
        $this->productFactory = $this->prophesize(ProductFactoryInterface::class);
        $this->productFactory->createFromRaw(
            Argument::any(),
            Argument::type('string'),
            Argument::type('string'),
            Argument::any()
        )->willReturn($this->prophesize(Product::class));

        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->eventDispatcher->dispatch(Argument::any());

        $this->productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $this->productRepository->save(Argument::type(Product::class))->will(
            static function () {
            }
        );
    }

    protected function getHandler() : CreateOrUpdateProductHandler
    {
        return new CreateOrUpdateProductHandler(
            $this->productFactory->reveal(),
            $this->productRepository->reveal(),
            $this->eventDispatcher->reveal()
        );
    }

    public function testItSaveNewProduct() : void
    {
        $command = new CreateProductCommand('x', 'y');
        $command->priceCurrency = 'z';

        $product = $this->prophesize(Product::class)->reveal();
        $this->productFactory->createFromRaw(null,'x', 'y', 'z')->willReturn($product);
        $this->productRepository->save($product)->shouldBeCalled();
        $this->eventDispatcher->dispatch(new ProductCreatedEvent($product))->shouldBeCalled();

        $this->getHandler()->handle($command);
    }

    public function testItUpdateExistingProduct() : void
    {
        $command = new UpdateProductCommand('id', 'x', 'y');

        $product = $this->prophesize(Product::class)->reveal();
        $this->productFactory->createFromRaw('id','x', 'y', null)->willReturn($product);
        $this->productRepository->save($product)->shouldBeCalled();
        $this->eventDispatcher->dispatch(new ProductUpdatedEvent($product))->shouldBeCalled();

        $this->getHandler()->handle($command);
    }
}
