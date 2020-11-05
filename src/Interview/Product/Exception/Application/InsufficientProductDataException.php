<?php


namespace App\Interview\Product\Exception\Application;


use Interview\Product\Exception\ProductExceptionInterface;
use InvalidArgumentException;

class InsufficientProductDataException extends InvalidArgumentException implements ProductExceptionInterface
{
    public static function forNoProductName() : InsufficientProductDataException
    {
        return new static('Product name is required to create product');
    }

    public static function forNoProductPriceAmount() : InsufficientProductDataException
    {
        return new static('Product price amount is required to create product');
    }
}
