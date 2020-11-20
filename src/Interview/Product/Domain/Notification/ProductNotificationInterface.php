<?php


namespace Interview\Product\Domain\Notification;


use Interview\Product\Domain\Event\ProductCreatedEvent;

interface ProductNotificationInterface
{
    public function notifyProductCreated(ProductCreatedEvent $event) : void;
}
