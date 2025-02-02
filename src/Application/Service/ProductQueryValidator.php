<?php

namespace App\Application\Service;

use App\Domain\ValueObject\FloatValueObject;
use App\Domain\ValueObject\ProductQueryParams;
use Symfony\Component\HttpFoundation\Request;

class ProductQueryValidator
{
    public function validate(Request $request): ProductQueryParams
    {
        $category = $request->query->get('category');
        $priceLessThan = $request->query->get('priceLessThan');

        if ($priceLessThan !== null) {

            $priceLessThan = new FloatValueObject($priceLessThan);
        }

        return new ProductQueryParams($category, $priceLessThan);
    }
}
