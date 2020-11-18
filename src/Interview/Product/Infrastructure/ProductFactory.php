<?php


namespace Interview\Product\Infrastructure;


use Interview\Product\Domain\ProductFactory as DomainProductFactory;
use Interview\Product\Domain\ProductName;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;

class ProductFactory extends DomainProductFactory
{
    public function createFromRaw(
        string $code,
        string $name,
        string $priceAmount,
        ?string $priceCurrency = null
    ) : Product {
        $currency = new Currency($priceCurrency ?? $this->defaultPriceCurrency);

        return new Product(Uuid::fromString($code), new ProductName($name), new Money($priceAmount, $currency));
    }
}
