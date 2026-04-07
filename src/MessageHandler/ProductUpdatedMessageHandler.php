<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Service\ProductManager;
use App\SharedBundle\Message\ProductUpdatedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ProductUpdatedMessageHandler
{
    public function __construct(
        private ProductManager $productManager,
    ) {
    }

    public function __invoke(ProductUpdatedMessage $message): void
    {
        $this->productManager->update($message->getProduct());
    }
}