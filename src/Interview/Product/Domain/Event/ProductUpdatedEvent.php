<?php


namespace Interview\Product\Domain\Event;


use Interview\Product\Domain\Product;

class ProductUpdatedEvent
{
    public Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

}
