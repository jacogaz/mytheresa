<?php

namespace App\Application\Command;

class GetProductsQuery
{
    public function __construct(private ?string $category = null, private ?int $priceLessThan = null)
    {
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getPriceLessThan(): ?int
    {
        return $this->priceLessThan;
    }
}
