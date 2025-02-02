<?php

namespace App\Application\Handler;

use App\Application\Command\GetProductsQuery;
use App\Application\Mapper\ProductMapper;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\Service\ProductPricingService;

class GetProductsQueryHandler
{
    public function __construct(private ProductRepositoryInterface $productRepository, private ProductPricingService $pricingService)
    {
    }

    public function __invoke(GetProductsQuery $query)
    {
        $category = $query->getCategory();
        $priceLessThan = $query->getPriceLessThan();

        if ($category) {
            $products = $this->productRepository->findByCategory($category);
        } else if ($priceLessThan) {
            $products = $this->productRepository->findByPriceLessThan($priceLessThan);
        } else {
            $products = $this->productRepository->findAll();
        }

        foreach ($products->toArray() as $product) {
            $this->pricingService->applyDiscounts($product);
        }

        $productsArray = ProductMapper::mapCollectionToArray($products);
        return array_slice($productsArray, 0, 5);
    }
}
