<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;

final class OrderResponseFactory implements OrderResponseFactoryInterface
{
    public function one(Order $order): array
    {
        return [
            'orderId' => $order->getId()->toRfc4122(),
            'product' => [
                'id' => $order->getProduct()->getId()->toRfc4122(),
                'name' => $order->getProduct()->getName(),
                'price' => $order->getProduct()->getPrice()->asFloat(),
                'quantity' => $order->getProduct()->getQuantity(),
            ],
            'customerName' => $order->getCustomerName(),
            'quantityOrdered' => $order->getQuantityOrdered(),
            'orderStatus' => $order->getOrderStatus()->value,
        ];
    }

    /**
     * @param Order[] $orders
     */
    public function many(array $orders): array
    {
        return [
            'data' => array_map(
                fn(Order $order) => $this->one($order),
                $orders
            ),
        ];
    }
}