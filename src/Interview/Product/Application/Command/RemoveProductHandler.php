<?php


namespace Interview\Product\Application\Command;


use Interview\Product\Domain\ProductRepositoryInterface;
use Ramsey\Uuid\Uuid;

class RemoveProductHandler
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function handle(RemoveProductCommand $command) : void
    {
        $this->productRepository->remove(Uuid::fromString($command->id));
    }
}
