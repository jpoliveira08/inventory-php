<?php

declare(strict_types=1);

namespace Inventory\Controllers\Api;

use Exception;
use Inventory\Http\Request;
use Inventory\Repositories\ProductRepository;
use Inventory\Services\PaginationService;

class ProductController extends Api
{
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    /**
     * Responsible for the return all products
     *
     * @param Request $request
     * @return array
     */
    public function getProducts(Request $request): array {
        return [
            'products' => $this->productRepository->getProductsPaginated(
                $request, 
                $paginationService
            ),
            'pagination' => parent::getPagination($request, $paginationService),
        ];
    }

    /**
     * Responsible for return data from one product
     *
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public function getProduct(Request $request, int $id): array
    {
        // Search for the product
        $product = $this->productRepository->getProductById($id);
        $request->getRouter()->setContentType('application/json');
        
        if (empty($product)) {
            throw new Exception('Product Not Found', 404);
        }
        
        return $product;
    }
}