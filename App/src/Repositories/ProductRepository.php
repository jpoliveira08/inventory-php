<?php

declare(strict_types=1);

namespace Inventory\Repositories;

use Inventory\Interfaces\ProductRepositoryInterface;
use Inventory\Persistence\ConnectionCreator;
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
            $productDetails['value']
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

    public function getAllProducts(): array
    {
        $query = 'SELECT FROM products';
        $stmt = $this->connection->query($query);

        return $stmt->fetchAll();
    }

    public function deleteProduct(int $productId): bool
    {
        $query = 'DELETE FROM products WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':id', $productId);

        return $stmt->execute();
    }
}