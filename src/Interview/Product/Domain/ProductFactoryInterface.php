<?php


namespace Interview\Product\Domain;


interface ProductFactoryInterface
{
    public function createFromRaw(string $name, string $priceAmount, string $priceCurrency = null) : Product;
}
