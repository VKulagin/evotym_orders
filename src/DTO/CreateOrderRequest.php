<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateOrderRequest
{
    #[Assert\NotBlank]
    public string $productId;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $customerName;

    #[Assert\NotNull]
    #[Assert\Positive]
    public int $quantityOrdered;

    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->productId = (string) ($data['productId'] ?? '');
        $dto->customerName = (string) ($data['customerName'] ?? '');
        $dto->quantityOrdered = (int) ($data['quantityOrdered'] ?? 0);

        return $dto;
    }
}