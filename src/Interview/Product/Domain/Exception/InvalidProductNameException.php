<?php


namespace App\Interview\Product\Domain\Exception;


use Interview\Product\Domain\Product;
use InvalidArgumentException;

class InvalidProductNameException extends InvalidArgumentException implements ProductExceptionInterface
{
    public static function forEmptyName() : InvalidProductNameException
    {
        return new static("Product name can not be empty");
    }

    public static function forTooShortName() : InvalidProductNameException
    {
        return new static('Product name must have at least ' . Product::MINIMUM_NAME_LENGTH. ' characters');
    }
}
