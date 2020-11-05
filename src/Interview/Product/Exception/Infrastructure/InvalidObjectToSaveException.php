<?php


namespace Interview\Product\Exception\Infrastructure;


use Interview\Product\Exception\ProductExceptionInterface;
use Interview\Product\Infrastructure\Product;
use InvalidArgumentException;

class InvalidObjectToSaveException extends InvalidArgumentException implements ProductExceptionInterface
{
    public static function forNonInfrastructureProductObject() : InvalidObjectToSaveException
    {
        return new static("Only product of klass " . Product::class . " can be save.");
    }
}
