<?php


namespace Interview\Product\Domain;


use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;

class ProductFactory implements ProductFactoryInterface
{
    protected string $defaultPriceCurrency;

    public function __construct(string $defaultPriceCurrency)
    {
        $this->defaultPriceCurrency = $defaultPriceCurrency;
    }

    public function createFromRaw(string $code, string $name, string $priceAmount, ?string $priceCurrency = null) : Product
    {
        $currency = new Currency($priceCurrency ?? $this->defaultPriceCurrency);

        return new Product(Uuid::fromString($code), new ProductName($name), new Money($priceAmount, $currency));
    }
}
