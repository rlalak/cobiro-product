<?php


namespace Interview\Product\Infrastructure;


use Doctrine\ORM\EntityManagerInterface;
use Interview\Product\Domain\Product;
use Interview\Product\Domain\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    private ServiceEntityRepository $entityRepository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(ServiceEntityRepository $entityRepository, EntityManagerInterface $entityManager)
    {
        $this->entityRepository = $entityRepository;
        $this->entityManager = $entityManager;
    }

    public function save(Product $product) : void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function getOneByName(string $name) : Product
    {
        /** @var Product $product */
        $product = $this->entityRepository->findOneBy(['name' => $name]);

        return $product;
    }
}
