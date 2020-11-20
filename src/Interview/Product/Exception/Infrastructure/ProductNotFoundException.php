<?php


namespace Interview\Product\Exception\Infrastructure;


use Interview\Product\Exception\ProductExceptionInterface;
use InvalidArgumentException;
use Ramsey\Uuid\UuidInterface;

class ProductNotFoundException  extends InvalidArgumentException implements ProductExceptionInterface
{
    public static function forId(UuidInterface $id) : ProductNotFoundException
    {
        return new static("Product with id `{$id}` not found.");
    }

    public static function forIdAsString(string $id) : ProductNotFoundException
    {
        return new static("Product with id `{$id}` not found.");
    }
}
