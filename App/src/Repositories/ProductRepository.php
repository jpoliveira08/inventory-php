<?php

declare(strict_types=1);

namespace Inventory\Repositories;

use Inventory\Http\Request;
use Inventory\Interfaces\ProductRepositoryInterface;
use Inventory\Persistence\ConnectionCreator;
use Inventory\Services\PaginationService;
use PDO;

class ProductRepository implements ProductRepositoryInterface
{
    private PDO $connection;
    private PriceRepository $priceRepository;

    public function __construct()
    {
        $this->connection = ConnectionCreator::createConnection();
        $this->priceRepository = new PriceRepository();
    }

    public function createProduct(array $productDetails): mixed
    {
        $priceId = $this->priceRepository->createPrice(
            ['value' => $productDetails['value']]
        );

        $query = 'INSERT INTO `products` (`price_id`, `name`, `color`)
            VALUES (:price_id, :name, :color)';
        
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':price_id', $priceId, PDO::PARAM_INT);
        $stmt->bindValue(':name', $productDetails['name'], PDO::PARAM_STR);
        $stmt->bindValue(':color', $productDetails['color'], PDO::PARAM_STR);
        $stmt->execute();

        return $this->connection->lastInsertId();
    }

    public function updateProduct(array $newProductDetails): bool
    {
        $this->priceRepository->updatePrice([
            'id' => $newProductDetails['price_id'],
            'value' => $newProductDetails['value']
        ]);

        $query = 'UPDATE `products` SET name = :name, color = :color
            WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':name', $newProductDetails['name']);
        $stmt->bindValue(':color', $newProductDetails['color']);
        $stmt->bindValue(':id', $newProductDetails['id']);

        return $stmt->execute();
    }

    public function getProductsPaginated(
        Request $request, 
        ?PaginationService &$paginationService
    ): array {
        $products = [];

        $queryForAmountOfProducts = 'SELECT COUNT(`id`) AS amount FROM products';
        $stmt = $this->connection->query($queryForAmountOfProducts);
        
        $amountOfProducts = $stmt->fetchObject()->amount;
        
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

        $paginationService = new PaginationService($amountOfProducts, $currentPage, 10);
        $queryForGetDataWithPagination = 'SELECT * FROM products ORDER BY id ASC LIMIT ' . $paginationService->getLimit();
        
        $stmtForPagination = $this->connection->query(
            $queryForGetDataWithPagination
        );

        
        while($product = $stmtForPagination->fetchObject()) {
            $products[] = [
                'id' => $product->id,
                'price_id' => $product->price_id,
                'name' => $product->name,
                'color' => $product->color
            ];
        }

        return $products;
    }


    public function getProductById(int $productId): array
    {
        $query = 'SELECT * FROM products WHERE id = :id LIMIT 1';
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':id', $productId);
        $stmt->execute();
        $productData = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($productData)) {
            return [];
        }
        
        $priceData = $this->priceRepository->getPriceById($productData['price_id']);

        unset($productData['price_id']);

        return array_merge($productData, ['value' => $priceData['value']]);
    }

    public function deleteProduct(int $productId): bool
    {
        $query = 'DELETE FROM products WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':id', $productId);

        return $stmt->execute();
    }
}