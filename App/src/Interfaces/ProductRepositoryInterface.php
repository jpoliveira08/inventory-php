<?php

declare(strict_types=1);

namespace Inventory\Interfaces;

interface ProductRepositoryInterface
{
    public function createProduct(array $productDetails): mixed;
    public function updateProduct(array $newProductDetails): bool;
    public function getAllProducts(): array;
    public function deleteProduct(int $productID): bool;
}