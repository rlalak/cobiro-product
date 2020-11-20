<?php


namespace Interview\Product\Domain\Event;


class ProductProjector
{
    public function whenProductCreated(ProductCreatedEvent $event) : void
    {
//        var_dump('whenProductCreated', $event->product);
    }

    public function whenProductUpdated(ProductUpdatedEvent $event) : void
    {
//        var_dump('whenProductUpdated', $event->product);
    }

    public function whenProductRemoved(ProductRemovedEvent $event) : void
    {
//        var_dump('whenProductRemoved', $event->id);
    }
}
