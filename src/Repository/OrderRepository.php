<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $order, bool $flush = true): void
    {
        $this->getEntityManager()->persist($order);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneByUuid(string $id): ?Order
    {
        return $this->find(Uuid::fromString($id));
    }
}