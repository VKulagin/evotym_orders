<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;

interface OrderResponseFactoryInterface
{
    public function one(Order $order): array;

    /**
     * @param Order[] $orders
     */
    public function many(array $orders): array;
}