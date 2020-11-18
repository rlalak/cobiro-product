<?php


namespace Interview\Product\Infrastructure\Doctrine\ORM;


use Doctrine\ORM\EntityManagerInterface;
use Interview\Product\Domain\Product as DomainProduct;
use Interview\Product\Domain\ProductRepositoryInterface;
use Interview\Product\Exception\Infrastructure\InvalidObjectToSaveException;
use Interview\Product\Infrastructure\Product;

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

    public function save(DomainProduct $product) : void
    {
        if ($product instanceof Product) {
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        } else {
            throw InvalidObjectToSaveException::forNonInfrastructureProductObject();
        }

    }

    public function getOneByName(string $name) : Product
    {
        /** @var Product $product */
        $product = $this->entityRepository->findOneBy(['name' => $name]);

        return $product;
    }
}
