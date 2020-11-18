<?php


namespace Interview\Product\Application\Command;


class SaveProductCommand
{
    public string $name;
    public string $priceAmount;
    public ?string $priceCurrency = null;
    public ?string $code = null;

    public function __construct(string $name, string $priceAmount)
    {
        $this->name = $name;
        $this->priceAmount = $priceAmount;
    }
}
