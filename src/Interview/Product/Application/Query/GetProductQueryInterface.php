<?php


namespace Interview\Product\Application\Query;


interface GetProductQueryInterface
{
    public function getProduct(string $productId) : ProductView;

    /**
     * @return ProductView[]
     */
    public function getAlProducts() : array;
}
