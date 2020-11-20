<?php


namespace Interview\Product\Exception\Domain;


use Interview\Product\Exception\ProductExceptionInterface;
use InvalidArgumentException;
use Ramsey\Uuid\Exception\InvalidUuidStringException;

class InvalidProductIdException extends InvalidArgumentException implements ProductExceptionInterface
{
    public static function forInvalidUuidStringException(InvalidUuidStringException $exception) : InvalidProductIdException
    {
        return new static('Invalid product id: ' . $exception->getMessage());
    }
}
