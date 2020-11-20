<?php


namespace Interview\Product\Application\Command;


use Interview\Product\Domain\Event\ProductRemovedEvent;
use Interview\Product\Domain\ProductRepositoryInterface;
use Interview\Product\Exception\Infrastructure\ProductNotFoundException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RemoveProductHandler
{
    protected ProductRepositoryInterface $productRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->productRepository = $productRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(RemoveProductCommand $command) : void
    {
        $id = Uuid::fromString($command->id);

        try {
            $this->productRepository->remove($id);

            $this->eventDispatcher->dispatch(new ProductRemovedEvent($id));
        } catch (ProductNotFoundException $exception) {
            // do nothing if product didn't exist
        }
    }
}
