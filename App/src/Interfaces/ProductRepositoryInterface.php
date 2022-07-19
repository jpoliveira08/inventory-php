<?php

declare(strict_types=1);

namespace Inventory\Interfaces;

use Inventory\Http\Request;
use Inventory\Services\PaginationService;

interface ProductRepositoryInterface
{
    public function createProduct(array $productDetails): mixed;
    public function updateProduct(array $newProductDetails, int $productId): bool;
    public function getProductsPaginated(
        Request $request, 
        ?PaginationService &$paginationService
    ): array;
    public function deleteProduct(int $productId): bool;
}