<?php

declare(strict_types=1);

namespace App\Entity;

use DomainException;
use InvalidArgumentException;
use App\Repository\ProductReferenceRepository;
use App\SharedBundle\Doctrine\MappedSuperclass\AbstractProduct;
use App\SharedBundle\ValueObject\Money;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductReferenceRepository::class)]
#[ORM\Table(name: 'products')]
class ProductReference extends AbstractProduct
{
    public static function create(
        Uuid $id,
        string $name,
        Money $price,
        int $quantity,
    ): self
    {
        $product = new self();
        $product->id = $id;
        $product->name = $name;
        $product->setPrice($price);
        $product->quantity = $quantity;

        return $product;
    }

    public function updateFromMessage(
        string $name,
        Money $price,
        int $quantity,
    ): void
    {
        $this->name = $name;
        $this->setPrice($price);
        $this->quantity = $quantity;
    }

    public function decreaseQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('Quantity must be greater than zero.');
        }

        if ($this->quantity < $quantity) {
            throw new DomainException('Not enough product quantity available.');
        }

        $this->quantity -= $quantity;
    }
}