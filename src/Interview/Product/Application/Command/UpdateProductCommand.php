<?php


namespace Interview\Product\Application\Command;


class UpdateProductCommand extends CreateProductCommand
{
    public string $id;
    public string $name;
    public string $priceAmount;
    public ?string $priceCurrency = null;

    public function __construct(string $id, string $name, string $priceAmount)
    {
        $this->id = $id;

        parent::__construct($name, $priceAmount);
    }
}
