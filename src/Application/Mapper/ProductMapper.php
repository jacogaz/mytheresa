<?php

namespace App\Application\Mapper;

use App\Domain\Entity\Product;
use App\Domain\ValueObject\ProductCollection;

class ProductMapper
{
    public static function mapCollectionToArray(ProductCollection $products): array
    {
        return array_map(function (Product $product) {
            return [
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'category' => $product->getCategory(),
                'price' => $product->getPrice()->toArray(),
            ];
        }, $products->toArray());
    }
}
