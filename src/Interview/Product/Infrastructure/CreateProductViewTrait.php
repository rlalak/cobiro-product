<?php


namespace Interview\Product\Infrastructure;


use Interview\Product\Application\Query\ProductView;

trait CreateProductViewTrait
{
    protected function createProductViewFromArray(array $productData) : ProductView
    {
        $product = new ProductView();
        $product->id = $productData['id'];
        $product->name = $productData['name'];
        $product->price = $productData['price_amount'];
        $product->currency = $productData['price_currency'];

        return $product;
    }
}
