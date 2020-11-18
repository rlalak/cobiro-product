<?php


namespace Interview\Product\Domain;


interface ProductFactoryInterface
{
    public function createFromRaw(string $code, string $name, string $priceAmount, string $priceCurrency = null) : Product;
}
