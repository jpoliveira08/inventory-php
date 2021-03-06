<?php

declare(strict_types=1);

use Inventory\Controllers\Api\ProductController;
use Inventory\Http\Response;

$productController = new ProductController();

$router->get('/api/v1/products', [
    function ($request) use ($productController){
        return new Response(
            200,
            $productController->getProducts($request), 
            'application/json'
        );
    }
]);

// Query for individual product
$router->get('/api/v1/products/{id}', [
    function ($request, $id) use ($productController){
        return new Response(
            200,
            $productController->getProduct($request, (int) $id), 
            'application/json'
        );
    }
]);

// Create product
$router->post('/api/v1/products', [
    function ($request) use ($productController){
        return new Response(
            201,
            $productController->setNewProduct($request), 
            'application/json'
        );
    }
]);

// Update product
$router->put('/api/v1/products/{id}', [
    function ($request, $id) use ($productController){
        return new Response(
            200,
            $productController->updateProduct($request, (int) $id), 
            'application/json'
        );
    }
]);

// Delete product
$router->delete('/api/v1/products/{id}', [
    function ($request, $id) use ($productController){
        return new Response(
            200,
            $productController->deleteProduct($request, (int) $id), 
            'application/json'
        );
    }
]);