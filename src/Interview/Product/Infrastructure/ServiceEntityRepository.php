<?php
/**
 * Created by mliwinski
 * Date: 21.01.19
 * Time: 12:56
 */

declare(strict_types=1);

namespace Interview\Product\Infrastructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository as DoctrineServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Interview\Product\Domain\Product;

class ServiceEntityRepository extends DoctrineServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
}
