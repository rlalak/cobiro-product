<?php


namespace Interview\Product\Application\Command;


class RemoveProductCommand
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
