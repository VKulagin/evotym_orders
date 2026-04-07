<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\SharedBundle\Message\OrderCompletedMessage;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class OrderPublisher
{
    public function __construct(
        private MessageBusInterface $bus,
    ) {
    }

    public function publishCompleted(Order $order): void
    {
        $this->bus->dispatch(
            new OrderCompletedMessage(
                orderId: $order->getId()->toRfc4122(),
                productId: $order->getProduct()->getId()->toRfc4122(),
                customerName: $order->getCustomerName(),
                quantityOrdered: $order->getQuantityOrdered(),
                orderStatus: $order->getOrderStatus()->value,
            )
        );
    }
}