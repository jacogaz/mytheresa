<?php

namespace App\Domain\Service;

use App\Domain\Entity\Product;

class ProductPricingService
{
    const CATEGORY_DISCOUNT = 30;

    public function applyDiscounts(Product $product): void
    {
        if ($product->getCategory() === 'boots') {
            $product->setDiscountPercentage(max(self::CATEGORY_DISCOUNT, $product->getDiscountPercentage()));
        }
        $originalPrice = $product->getPrice()->getOriginal();
        $discountPercentage = $product->getDiscountPercentage();

        if ($discountPercentage !== null) {
            $finalPrice = $originalPrice * (1 - ($discountPercentage / 100));
            $product->getPrice()->setFinal($finalPrice);
            $product->getPrice()->setDiscountPercentage($discountPercentage);
        } else {
            $product->getPrice()->setFinal($originalPrice);
        }
    }
}
