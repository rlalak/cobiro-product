<?php


namespace Interview\Product\Application\Command;


use Interview\Product\Domain\ProductFactoryInterface;
use Interview\Product\Domain\ProductRepositoryInterface;

class CreateOrUpdateProductHandler
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
        $product = $this->productFactory->createFromRaw(
            $command instanceof UpdateProductCommand ? $command->id :null,
            $command->name,
            $command->priceAmount,
            $command->priceCurrency
        );

        $this->productRepository->save($product);
    }
}
