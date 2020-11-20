<?php


namespace Interview\Product\Domain;


interface ProductFactoryInterface
{
    public function createFromRaw(?string $id, string $name, string $priceAmount, string $priceCurrency = null) : Product;
}
