<?php


namespace Interview\Product\Application;


class CreateProductCommand
{
    public ?string $name = null;
    public ?string $priceAmount = null;
    public ?string $priceCurrency = null;
}
