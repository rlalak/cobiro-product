<?php


namespace Interview\Product\Exception\Domain;


use Interview\Product\Domain\ProductName;
use Interview\Product\Exception\ProductExceptionInterface;
use InvalidArgumentException;

class InvalidProductNameException extends InvalidArgumentException implements ProductExceptionInterface
{
    public static function forEmptyName() : InvalidProductNameException
    {
        return new static("Product name can not be empty");
    }

    public static function forTooShortName() : InvalidProductNameException
    {
        return new static('Product name must have at least ' . ProductName::MINIMUM_NAME_LENGTH. ' characters');
    }
}
