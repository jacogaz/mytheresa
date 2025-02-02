<?php

namespace App\Domain\ValueObject;

class ProductQueryParams
{
    private $category;
    private $priceLessThan;

    public function __construct($category, $priceLessThan)
    {
        $this->category = $category;
        $this->priceLessThan = $priceLessThan;

        $this->validate();
    }

    private function validate(): void
    {
        if ($this->priceLessThan !== null &&$this->priceLessThan->getValue() !== null && $this->priceLessThan->getValue() < 0) {
            throw new \InvalidArgumentException('Price must be positive.');
        }

        if ($this->category !== null && !is_string($this->category)) {
            throw new \InvalidArgumentException('Category must be string');
        }
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getPriceLessThan()
    {
        return $this->priceLessThan;
    }
}
