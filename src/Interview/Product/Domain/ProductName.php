<?php


namespace Interview\Product\Domain;


use Interview\Product\Exception\Domain\InvalidProductNameException;

class ProductName
{
    public const MINIMUM_NAME_LENGTH = 3;

    protected string $name;

    /**
     * ProductName constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $name = trim($name);

        if (empty($name)) {
            throw InvalidProductNameException::forEmptyName();
        }

        if (strlen($name) < static::MINIMUM_NAME_LENGTH) {
            throw InvalidProductNameException::forTooShortName();
        }

        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
