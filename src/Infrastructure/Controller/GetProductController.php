<?php

namespace App\Infrastructure\Controller;

use App\Application\Command\GetProductsQuery;
use App\Application\Handler\GetProductsQueryHandler;
use App\Application\Service\ProductQueryValidator;
use App\Domain\ValueObject\ProductQueryParams;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetProductController extends AbstractController
{
    public function __construct(
        private GetProductsQueryHandler $getProductsQueryHandler,
        private ProductQueryValidator $productQueryValidator
        )
    {
    }

    #[Route(path: '/products', name: 'get_products', methods: ['GET'])]
    public function getProducts(Request $request)
    {
        $queryParams = $this->productQueryValidator->validate($request);

        $query = new GetProductsQuery($queryParams->getCategory(), $queryParams->getPriceLessThan()?->getValue());

        try{
            $products = $this->getProductsQueryHandler->__invoke($query);
            return new JsonResponse($products);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Internal Server Error',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}

