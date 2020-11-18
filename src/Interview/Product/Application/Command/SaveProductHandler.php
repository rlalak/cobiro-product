<?php


namespace Interview\Product\Application\Command;


use Interview\Product\Domain\ProductFactoryInterface;
use Interview\Product\Domain\ProductRepositoryInterface;
use Ramsey\Uuid\Uuid;

class SaveProductHandler
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

    public function handle(SaveProductCommand $command) : void
    {
        $code = $command->code;

        if ($code === null) {
            $code = Uuid::uuid4();
        }

        $product = $this->productFactory->createFromRaw(
            $code,
            $command->name,
            $command->priceAmount,
            $command->priceCurrency
        );

        $this->productRepository->save($product);
    }
}
