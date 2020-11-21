<?php


namespace Interview\Product\Application\Query;


interface GetProductQueryInterface
{
    public function getProduct(string $id) : ProductView;

    /**
     * @return ProductView[]
     */
    public function getAllProducts() : array;
}
