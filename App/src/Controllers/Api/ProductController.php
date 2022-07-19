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

    /**
     * Responsible for create a new product
     *
     * @param Request $request
     * @return array
     */
    public function setNewProduct(Request $request): array
    {
        $postVars = $request->getPostVars();
        $request->getRouter()->setContentType('application/json');
        if (
            !isset($postVars['name']) ||
            !isset($postVars['color']) ||
            !isset($postVars['value'])
        ) {
            throw new Exception("The fields 'name', 'color' and 'value' are requireds", 400);
        }
        
        if (!is_numeric($postVars['value'])) {
            throw new Exception("The value must be a numeric value", 400);
        }

        $newPRoductId = $this->productRepository->createProduct($postVars);

        return [
            "type" => "success",
            "productId" => $newPRoductId
        ];
    }

    /**
     * Responsible for updated a product
     *
     * @param Request $request
     * @param integer $productId
     * @return array
     */
    public function updateProduct(Request $request, int $productId): array
    {
        $postVars = $request->getPostVars();
        $request->getRouter()->setContentType('application/json');
        if (
            !isset($postVars['name']) ||
            !isset($postVars['color']) ||
            !isset($postVars['value'])
        ) {
            throw new Exception("The fields 'name', 'color' and 'value' are requireds", 400);
        }
        
        if (!is_numeric($postVars['value'])) {
            throw new Exception("The value must be a numeric value", 400);
        }

        $product = $this->productRepository->getProductById($productId);

        if (empty($product)) {
            throw new Exception('Product Not Found', 404);
        }

        $update = $this->productRepository->updateProduct(
            array_merge($postVars, ['price_id' => $product['price_id']]), 
            $productId
        );

        if (!$update) {
            throw new Exception("Error updating the product", 500);
        }

        return [
            "type" => "success",
            "message" => true
        ];
    }

    /**
     * Responsible for delete a product
     *
     * @param Request $request
     * @param integer $productId
     * @return array
     */
    public function deleteProduct(Request $request, int $productId): array
    {
        $product = $this->productRepository->getProductById($productId);

        if (empty($product)) {
            throw new Exception('Product Not Found', 404);
        }

        $delete = $this->productRepository->deleteProduct($productId);

        if (!$delete) {
            throw new Exception("Error deleting the product", 500);
        }

        return [
            "type" => "success",
            "message" => true
        ];
    }
}
