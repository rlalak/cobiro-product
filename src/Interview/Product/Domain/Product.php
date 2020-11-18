<?php


namespace Interview\Product\Domain;


use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Product
{
    protected ProductName $name;
    protected Money $price;
    protected UuidInterface $code;

    public function __construct(UuidInterface $code, ProductName $name, Money $price)
    {
        $this->name = $name;
        $this->price = $price;

        $this->code = Uuid::uuid1();
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
