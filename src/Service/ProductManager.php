<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Uid\Uuid;
use App\Entity\ProductReference;
use App\SharedBundle\ValueObject\Money;
use App\SharedBundle\DTO\ProductPayload;
use App\Repository\ProductReferenceRepository;

final readonly class ProductManager
{
    public function __construct(
        private ProductReferenceRepository $productRepository,
    )
    {
    }

    public function create(ProductPayload $payload): void
    {
        $existing = $this->getById($payload->id);

        if ($existing !== null) {
            return;
        }

        $product = ProductReference::create(
            id: Uuid::fromString($payload->id),
            name: $payload->name,
            price: Money::fromFloat($payload->price, 'USD'),
            quantity: $payload->quantity,
        );

        $this->productRepository->save($product);
    }

    public function update(ProductPayload $payload): void
    {
        $product = $this->getById($payload->id);

        if ($product === null) {
            return;
        }

        $product->updateFromMessage(
            name: $payload->name,
            price: Money::fromFloat($payload->price, 'USD'),
            quantity: $payload->quantity,
        );

        $this->productRepository->save($product);
    }

    public function getById(string $id): ?ProductReference
    {
        return $this->productRepository->findOneByUuid($id);
    }
}