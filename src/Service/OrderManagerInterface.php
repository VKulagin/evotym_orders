<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreateOrderRequest;
use App\Entity\Order;

interface OrderManagerInterface
{
    public function create(CreateOrderRequest $request): Order;

    /**
     * @return Order[]
     */
    public function getAll(): array;

    public function getById(string $id): ?Order;
}