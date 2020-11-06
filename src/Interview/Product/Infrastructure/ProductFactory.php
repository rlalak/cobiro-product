<?php


namespace Interview\Product\Infrastructure;


use Interview\Product\Domain\ProductFactory as DomainProductFactory;
use Money\Money;

class ProductFactory extends DomainProductFactory
{
    public function createFromRaw(string $name, string $priceAmount, ?string $priceCurrency = null) : Product
    {
        return new Product($name, new Money($priceAmount, $this->getCurrency($priceCurrency)));
    }
}
