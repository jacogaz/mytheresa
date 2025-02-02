<?php

namespace Tests\Application\Handler;

use App\Application\Command\GetProductsQuery;
use App\Application\Handler\GetProductsQueryHandler;
use App\Application\Mapper\ProductMapper;
use App\Domain\Entity\Price;
use App\Domain\Entity\Product;
use App\Domain\ValueObject\ProductCollection;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\Service\ProductPricingService;
use PHPUnit\Framework\TestCase;

class GetProductsQueryHandlerTest extends TestCase
{
    private ProductRepositoryInterface $productRepository;
    private ProductPricingService $pricingService;
    private GetProductsQueryHandler $handler;

    protected function setUp(): void
    {
        $this->productRepository = $this->createMock(ProductRepositoryInterface::class);
        $this->pricingService = $this->createMock(ProductPricingService::class);
        $this->handler = new GetProductsQueryHandler($this->productRepository, $this->pricingService);
    }

    public function testHandleReturnsProductsFilteredByCategory()
    {
        $query = new GetProductsQuery(category: 'boots', priceLessThan: null);
        $products = new ProductCollection([new Product('000001', 'Boot', 'boots', new Price(100, 100, null, 'EUR'))]);
        
        $this->productRepository->expects($this->once())
            ->method('findByCategory')
            ->with('boots')
            ->willReturn($products);

        $this->pricingService->expects($this->once())
            ->method('applyDiscounts');

        ProductMapper::class::mapCollectionToArray($products);
        
        $result = ($this->handler)($query);
        
        $this->assertCount(1, $result);
    }

    public function testHandleReturnsProductsFilteredByPrice()
    {
        $query = new GetProductsQuery(category: null, priceLessThan: 150);
        $products = new ProductCollection([new Product('000002', 'Shoe', 'shoes', new Price(120, 120, null, 'EUR'))]);
        
        $this->productRepository->expects($this->once())
            ->method('findByPriceLessThan')
            ->with(150)
            ->willReturn($products);

        $this->pricingService->expects($this->once())
            ->method('applyDiscounts');
        
        $result = ($this->handler)($query);
        
        $this->assertCount(1, $result);
    }

    public function testHandleReturnsAllProductsWhenNoFiltersAreApplied()
    {
        $query = new GetProductsQuery(category: null, priceLessThan: null);
        $products = new ProductCollection([
            new Product('000003', 'Hat', 'accessories', new Price(50, 50, null, 'EUR')),
            new Product('000004', 'Gloves', 'accessories', new Price(70, 70, null, 'EUR'))
        ]);

        $this->productRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($products);

        $this->pricingService->expects($this->exactly(2))
            ->method('applyDiscounts');
        
        $result = ($this->handler)($query);
        
        $this->assertCount(2, $result);
    }
}
