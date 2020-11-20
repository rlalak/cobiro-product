<?php


namespace Interview\Product\Domain;


use Money\Money;
use Ramsey\Uuid\UuidInterface;

class Product
{
    protected UuidInterface $id;
    protected ProductName $name;
    protected Money $price;

    public function __construct(UuidInterface $id, ProductName $name, Money $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId() : UuidInterface
    {
        return $this->id;
    }

    public function getName() : ProductName
    {
        return $this->name;
    }

    public function getPrice() : Money
    {
        return $this->price;
    }


}
