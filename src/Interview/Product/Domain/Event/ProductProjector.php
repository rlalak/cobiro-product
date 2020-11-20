<?php


namespace Interview\Product\Domain\Event;


use Interview\Product\Domain\ProductProjectionInterface;

class ProductProjector
{
    private ProductProjectionInterface $projection;

    public function __construct(ProductProjectionInterface $projection)
    {
        $this->projection = $projection;
    }

    public function whenProductCreated(ProductCreatedEvent $event) : void
    {
        $this->projection->updateProduct(
            $event->product->getId(),
            $event->product->getName(),
            $event->product->getPrice()->getAmount(),
            $event->product->getPrice()->getCurrency(),
        );
    }

    public function whenProductUpdated(ProductUpdatedEvent $event) : void
    {
        $this->projection->updateProduct(
            $event->product->getId(),
            $event->product->getName(),
            $event->product->getPrice()->getAmount(),
            $event->product->getPrice()->getCurrency(),
        );
    }

    public function whenProductRemoved(ProductRemovedEvent $event) : void
    {
        $this->projection->removeProduct($event->id);
    }
}
