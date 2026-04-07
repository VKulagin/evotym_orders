<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderRepository;
use App\SharedBundle\Enum\OrderStatus;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'orders')]
class Order
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: ProductReference::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ProductReference $product;

    #[ORM\Column(length: 255)]
    private string $customerName;

    #[ORM\Column(type: 'integer')]
    private int $quantityOrdered;

    #[ORM\Column(length: 50, enumType: OrderStatus::class)]
    private OrderStatus $orderStatus;

    public function __construct(
        ProductReference $product,
        string $customerName,
        int $quantityOrdered,
    ) {
        $this->id = Uuid::v4();
        $this->product = $product;
        $this->customerName = $customerName;
        $this->quantityOrdered = $quantityOrdered;
        $this->orderStatus = OrderStatus::Processing;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getProduct(): ProductReference
    {
        return $this->product;
    }

    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    public function getQuantityOrdered(): int
    {
        return $this->quantityOrdered;
    }

    public function getOrderStatus(): OrderStatus
    {
        return $this->orderStatus;
    }

    public function complete(): void
    {
        $this->orderStatus = OrderStatus::Completed;
    }
}