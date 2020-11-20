<?php


namespace Interview\Product\Infrastructure;


use Interview\Product\Domain\Event\ProductCreatedEvent;
use Interview\Product\Domain\Notification\ProductNotificationInterface;

class ProductNotification implements ProductNotificationInterface
{
    public function notifyProductCreated(ProductCreatedEvent $event) : void
    {
        // use some user repository to get notification recipient
        // prepare Product data to use it in email template
        // us some Mailer to send Email notification
    }
}
