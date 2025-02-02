<?php

namespace App\Domain\Repository;

interface ProductRepositoryInterface
{
    public function findAll();
    public function findByCategory(string $category);
    public function findByPriceLessThan(int $price);
}
