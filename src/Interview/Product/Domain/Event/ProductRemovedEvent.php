<?php


namespace Interview\Product\Domain\Event;

use Ramsey\Uuid\UuidInterface;

class ProductRemovedEvent
{
    public UuidInterface $id;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }
}
