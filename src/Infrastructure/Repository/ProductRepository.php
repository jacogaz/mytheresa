<?php

namespace App\Infrastructure\Repository;

use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\Entity\Product;
use App\Domain\ValueObject\ProductCollection;
use App\Domain\Entity\Price;
use App\Infrastructure\FileReader;

class ProductRepository implements ProductRepositoryInterface
{
    private ProductCollection $allProducts;

    public function __construct(private FileReader $fileReader)
    {
        $this->allProducts = $this->loadProducts();
    }

    private function loadProducts(): ProductCollection
    {
        try {
            $data = $this->fileReader->readJsonFile();
            $collection = new ProductCollection([]);

            foreach ($data['products'] as $productData) {
                $price = new Price(
                    $productData['price'],
                    $productData['price'],
                    null,
                    'EUR'
                );

                $product = new Product(
                    $productData['sku'],
                    $productData['name'],
                    $productData['category'],
                    $price
                );

                $collection->add($product);
            }

            return $collection;
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to load products: " . $e->getMessage());
        }
    }

    public function findAll(): ProductCollection
    {
        return $this->allProducts;
    }

    public function findByCategory(string $category): ProductCollection
    {
        $filteredProducts = array_filter($this->allProducts->toArray(), function (Product $product) use ($category) {
            return $product->getCategory() === $category;
        });

        return new ProductCollection($filteredProducts);
    }

    public function findByPriceLessThan(int $price): ProductCollection
    {
        $filteredProducts = array_filter($this->allProducts->toArray(), function (Product $product) use ($price) {
            return $product->getPrice()->getOriginal() <= $price;
        });

        return new ProductCollection($filteredProducts);
    }
}
