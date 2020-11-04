<?php


namespace Interview\Product\Application;


use Interview\Product\Domain\ProductFactoryInterface;
use Interview\Product\Domain\ProductRepositoryInterface;

class CreateProductHandler
{
    protected ProductFactoryInterface $productFactory;
    protected ProductRepositoryInterface $productRepository;

    /**
     * CreateProductHandler constructor.
     * @param ProductFactoryInterface $productFactory
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductFactoryInterface $productFactory, ProductRepositoryInterface $productRepository)
    {
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
    }

    public function handle(CreateProductCommand $command) : void
    {
        if ($command->name === null) {
            //throw
        }

        if ($command->priceAmount === null) {
            //throw
        }

        $product = $this->productFactory->createFromRaw(
            $command->name,
            $command->priceAmount,
            $command->priceCurrency
        );

        $this->productRepository->save($product);
    }
}
