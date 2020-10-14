<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Product;
use App\Domain\Port\ProductGatewayInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository implements ProductGatewayInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product): void
    {
        $this->_em->persist($product);
        $this->_em->flush();
    }

    public function findByName(string $name): ?Product
    {
        return $this->findOneBy(['name' => $name]);
    }
}
