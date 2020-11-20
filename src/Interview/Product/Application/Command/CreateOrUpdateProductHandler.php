<?php


namespace Interview\Product\Application\Command;


use Interview\Product\Domain\Event\ProductCreatedEvent;
use Interview\Product\Domain\Event\ProductUpdatedEvent;
use Interview\Product\Domain\ProductFactoryInterface;
use Interview\Product\Domain\ProductRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateOrUpdateProductHandler
{
    protected ProductFactoryInterface $productFactory;
    protected ProductRepositoryInterface $productRepository;
    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(
        ProductFactoryInterface $productFactory,
        ProductRepositoryInterface $productRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(CreateProductCommand $command) : void
    {
        $product = $this->productFactory->createFromRaw(
            $command instanceof UpdateProductCommand ? $command->id : null,
            $command->name,
            $command->priceAmount,
            $command->priceCurrency
        );

        $this->productRepository->save($product);

        if ($command instanceof UpdateProductCommand) {
            $event = new ProductUpdatedEvent($product);
        } else {
            $event = new ProductCreatedEvent($product);
        }

        $this->eventDispatcher->dispatch($event);
    }
}
