<?php


namespace Interview\Product\Infrastructure\Doctrine\ORM;


use Doctrine\ORM\EntityManagerInterface;
use Interview\Product\Domain\Product;
use Interview\Product\Domain\ProductRepositoryInterface;
use Interview\Product\Exception\Infrastructure\ProductNotFoundException;
use Ramsey\Uuid\UuidInterface;

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
        $this->entityManager->merge($product);
        $this->entityManager->flush();
    }

    public function remove(UuidInterface $id) : void
    {
        $product = $this->entityRepository->find($id);
        if ($product === null) {
            throw ProductNotFoundException::forId($id);
        }
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
}
