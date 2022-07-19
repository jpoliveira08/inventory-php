<?php

declare(strict_types=1);

namespace Inventory\Controllers\Api;

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
}