<?php


namespace Interview\Product\Domain;


interface ProductRepositoryInterface
{
    public function save(Product $product) : void;
    public function getOneByName(string $name) : Product;
}
