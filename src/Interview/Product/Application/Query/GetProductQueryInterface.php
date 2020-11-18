<?php


namespace Interview\Product\Application\Query;


interface GetProductQueryInterface
{
    public function getProductDetails(string $productId) : ProductView;
}
