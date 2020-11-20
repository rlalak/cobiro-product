<?php


namespace Interview\Product\Domain;


use Interview\Product\Exception\Domain\InvalidProductIdException;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

class ProductFactory implements ProductFactoryInterface
{
    protected string $defaultPriceCurrency;

    public function __construct(string $defaultPriceCurrency)
    {
        $this->defaultPriceCurrency = $defaultPriceCurrency;
    }

    public function createFromRaw(?string $id, string $name, string $priceAmount, ?string $priceCurrency = null) : Product
    {
        $currency = new Currency($priceCurrency ?? $this->defaultPriceCurrency);

        try {
            $productId = $id === null ? Uuid::uuid4() : Uuid::fromString($id);
        } catch (InvalidUuidStringException $exception) {
            throw InvalidProductIdException::forInvalidUuidStringException($exception);
        }

        return new Product($productId, new ProductName($name), new Money($priceAmount, $currency));
    }
}
