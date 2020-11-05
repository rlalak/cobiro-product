<?php


namespace Interview\Product\Domain;


use App\Interview\Product\Domain\Exception\InvalidProductNameException;
use Money\Money;

class Product
{
    public const MINIMUM_NAME_LENGTH = 3;

    protected string $name;
    protected Money $price;

    public function __construct(string $name, Money $price)
    {
        $this->setName($name);
        $this->price = $price;
    }

    protected function setName(string $name) : void
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

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return Money
     */
    public function getPrice() : Money
    {
        return $this->price;
    }


}
