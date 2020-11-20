<?php


namespace Interview\Product\Domain;


use Ramsey\Uuid\UuidInterface;

interface ProductRepositoryInterface
{
    public function save(Product $product) : void;
    public function remove(UuidInterface $id) : void;
    public function getOneByName(string $name) : Product;
}
