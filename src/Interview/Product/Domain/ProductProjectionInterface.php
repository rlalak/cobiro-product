<?php


namespace Interview\Product\Domain;


interface ProductProjectionInterface
{
    public function updateProduct(string $id, string $name, string $priceAmount, string $priceCurrency) : void;
    public function removeProduct(string $id) : void;
    public function reset() : void;
}
