<?php


namespace UnitTests\Interview\Product\Application\Command;


use Interview\Product\Application\Command\RemoveProductCommand;
use Interview\Product\Application\Command\RemoveProductHandler;
use Interview\Product\Domain\Event\ProductRemovedEvent;
use Interview\Product\Domain\ProductRepositoryInterface;
use Interview\Product\Exception\Infrastructure\ProductNotFoundException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class RemoveProductHandlerTest
 * @package UnitTests\Interview\Product\Application\Command
 *
 * @covers \Interview\Product\Application\Command\RemoveProductHandler
 * @covers \Interview\Product\Application\Command\RemoveProductCommand
 * @covers \Interview\Product\Domain\Event\ProductRemovedEvent
 */
class RemoveProductHandlerTest extends TestCase
{
    /** @var ProductRepositoryInterface */
    protected $productRepository;
    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    protected function setUp() : void
    {
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->eventDispatcher->dispatch(Argument::any());

        $this->productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $this->productRepository->remove(Argument::type(UuidInterface::class))->will(
            static function () {
            }
        );
    }

    protected function getHandler() : RemoveProductHandler
    {
        return new RemoveProductHandler(
            $this->productRepository->reveal(),
            $this->eventDispatcher->reveal()
        );
    }

    public function testItRemoveProduct() : void
    {
        $uuid = Uuid::uuid1();

        $command = new RemoveProductCommand((string) $uuid);

        $this->productRepository->remove($uuid)->shouldBeCalled();
        $this->eventDispatcher->dispatch(new ProductRemovedEvent($uuid))->shouldBeCalled();

        $this->getHandler()->handle($command);
    }

    public function testItNotDispatchEventIfProductDidNotExist() : void
    {
        $uuid = Uuid::uuid1();

        $command = new RemoveProductCommand((string) $uuid);

        $this->productRepository->remove($uuid)->willThrow(ProductNotFoundException::class);
        $this->eventDispatcher->dispatch(new ProductRemovedEvent($uuid))->shouldNotBeCalled();

        $this->getHandler()->handle($command);
    }
}
