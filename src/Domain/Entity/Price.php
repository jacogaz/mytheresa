<?php

namespace App\Domain\Entity;

class Price
{
    private int $original;
    private int $final;
    private ?float $discountPercentage;
    private string $currency;

    public function __construct(int $original, int $final, ?float $discountPercentage, string $currency)
    {
        $this->original = $original;
        $this->final = $final;
        $this->discountPercentage = $discountPercentage;
        $this->currency = $currency;
    }

    public function getOriginal(): int
    {
        return $this->original;
    }

    public function getFinal(): int
    {
        return $this->final;
    }

    public function setFinal(int $final): void
    {
        $this->final = $final;
    }

    public function getDiscountPercentage(): ?float
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(float $discountPercentage): ?float
    {
        return $this->discountPercentage = $discountPercentage;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function applyDiscount(float $discountPercentage): void
    {
        $this->discountPercentage = $discountPercentage;
        $this->final = $this->original * (1 - $discountPercentage / 100);
    }

    public function toArray(): array
    {
        return [
            'original' => $this->original,
            'final' => $this->final,
            'discount_percentage' => $this->discountPercentage,
            'currency' => $this->currency,
        ];
    }
}
