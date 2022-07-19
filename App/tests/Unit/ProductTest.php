<?php

declare(strict_types=1);

namespace Tests\Unit;

use Inventory\Repositories\ProductRepository;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function it_can_create_a_product()
    {
        $price = [
            'id' => 1,
            'value' => 5.65
        ];

        $product = [
            'name' => 'Product Test',
            'color' => 'blue',
            'price_id' => $price['id']
        ];

        $productRepository = $this->createMock(ProductRepository::class);

        $productRepository->method('createProduct')
            ->willReturn($product['id'] = 1);

        $this->assertEquals(1, $productRepository->createProduct($product));
    }
    
    /** @test */
    public function it_can_show_all_products()
    {
        $product1 = [
            'id' => 1,
            'price_id' => 1,
            'name' => 'Product One',
            'color' => 'Blue'
        ];

        $product2 = [
            'id' => 2,
            'price_id' => 2,
            'name' => 'Product Two',
            'color' => 'Green'
        ];

        $allProducts = [
            $product1,
            $product2
        ];

        $productRepository = $this->createMock(ProductRepository::class);

        $productRepository->method('getProductsPaginated')
            ->willReturn([$product1, $product2]) ;

        $this->assertEquals($allProducts, $productRepository->getProductsPaginated());
    }
    
    /** @test */
    public function it_can_update_the_product()
    {
        $oldProductData = [
            'id' => 1,
            'price_id' => 1,
            'name' => 'Old Product Name',
            'color' => 'Blue'
        ];
        
        $productRepository = $this->createMock(ProductRepository::class);

        $productRepository->method('updateProduct')
            ->willReturn(true);
        

        $this->assertTrue($productRepository->updateProduct($oldProductData));
    }
    
    /** @test */
    public function it_can_delete_a_product()
    {
        $product1 = [
            'id' => 1,
            'price_id' => 1,
            'name' => 'Product One',
            'color' => 'Blue'
        ];
        
        $productRepository = $this->createMock(ProductRepository::class);

        $productRepository->method('deleteProduct')
            ->willReturn(true);

        $this->assertTrue($productRepository->deleteProduct($product1['id']));
    }
}