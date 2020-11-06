<?php


namespace Interview\Product\Domain;


use Money\Currency;
use Money\Money;

class ProductFactory implements ProductFactoryInterface
{
    protected string $defaultPriceCurrency;

    public function __construct(string $defaultPriceCurrency)
    {
        $this->defaultPriceCurrency = $defaultPriceCurrency;
    }

    public function createFromRaw(string $name, string $priceAmount, ?string $priceCurrency = null) : Product
    {
        return new Product($name, new Money($priceAmount, $this->getCurrency($priceCurrency)));
    }

    protected function getCurrency(?string $currency) : Currency
    {
        return new Currency($currency ?? $this->defaultPriceCurrency);
    }
}
