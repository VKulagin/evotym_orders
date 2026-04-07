<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Service\ProductManager;
use App\SharedBundle\Message\ProductCreatedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ProductCreatedMessageHandler
{
    public function __construct(
        private ProductManager $productManager,
    )
    {
    }

    public function __invoke(ProductCreatedMessage $message): void
    {
        $this->productManager->create($message->getProduct());
    }
}