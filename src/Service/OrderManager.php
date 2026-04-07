<?php

declare(strict_types=1);

namespace App\Service;

use DomainException;
use App\DTO\CreateOrderRequest;
use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductReferenceRepository;

final readonly class OrderManager implements OrderManagerInterface
{
    public function __construct(
        private OrderRepository $orderRepository,
        private ProductReferenceRepository $productRepository,
        private OrderPublisher $orderPublisher,
    )
    {
    }

    public function create(CreateOrderRequest $request): Order
    {
        $product = $this->productRepository->findOneByUuid($request->productId);

        if ($product === null) {
            throw new DomainException('Product not found.');
        }

        $order = new Order(
            product: $product,
            customerName: $request->customerName,
            quantityOrdered: $request->quantityOrdered,
        );

        $order->complete();

        $this->orderRepository->save($order);

        $this->orderPublisher->publishCompleted($order);

        return $order;
    }

    /**
     * @return Order[]
     */
    public function getAll(): array
    {
        return $this->orderRepository->findAll();
    }

    public function getById(string $id): ?Order
    {
        return $this->orderRepository->findOneByUuid($id);
    }
}