<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductReference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class ProductReferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductReference::class);
    }

    public function save(ProductReference $product, bool $flush = true): void
    {
        $this->getEntityManager()->persist($product);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneByUuid(string $id): ?ProductReference
    {
        return $this->find(Uuid::fromString($id));
    }
}