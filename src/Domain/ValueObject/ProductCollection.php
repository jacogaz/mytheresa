<?php

namespace App\Domain\ValueObject;

use App\Domain\Entity\Product;

class ProductCollection
{
    public function __construct(private array $products)
    {
    }

    public function add(Product $product): void
    {
        $this->products[] = $product;
    }

    public function toArray(): array
    {
        return $this->products;
    }
}
