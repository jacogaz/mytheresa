<?php

namespace App\Domain\Entity;

class Product
{
    private string $sku;
    private string $name;
    private string $category;
    private Price $price;
    private ?float $discountPercentage = null;
    private float $priceFinal;

    public function __construct(string $sku, string $name, string $category, Price $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->priceFinal = $price->getOriginal();
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getPriceFinal(): float
    {
        return $this->priceFinal;
    }

    public function getDiscountPercentage(): ?float
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(?float $discountPercentage): void
    {
        $this->discountPercentage = $discountPercentage;
    }

    public function setPriceFinal(float $priceFinal): void
    {
        $this->priceFinal = $priceFinal;
    }

    public function applyCategoryDiscount(float $categoryDiscountPercentage): void
    {
        if ($categoryDiscountPercentage > 0) {
            $this->discountPercentage = max($this->discountPercentage ?? 0, $categoryDiscountPercentage);
        }
    }

    public function applyDiscount(float $discountPercentage): void
    {
        $this->discountPercentage = max($this->discountPercentage ?? 0, $discountPercentage);
    }

    public function calculateFinalPrice(): void
    {
        $originalPrice = $this->price->getOriginal();
        if ($this->discountPercentage !== null) {
            $this->priceFinal = $originalPrice * (1 - ($this->discountPercentage / 100));
        } else {
            $this->priceFinal = $originalPrice;
        }
    }
}

