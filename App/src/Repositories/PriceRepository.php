<?php

declare(strict_types=1);

namespace Inventory\Repositories;

use Inventory\Interfaces\PriceRepositoryInterface;
use Inventory\Persistence\ConnectionCreator;
use PDO;

/**
 * PriceRepository class to handle the DB methods
 */
class PriceRepository implements PriceRepositoryInterface
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = ConnectionCreator::createConnection();
    }

    /**
     * Responsible for create a record in price table's.
     *
     * @param array $priceDetails
     * @return void
     */
    public function createPrice(array $priceDetails)
    {
        $query = 'INSERT INTO prices (`value`) VALUES (:value)';
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':value', $priceDetails['value']);
        $stmt->execute();
        
        return $this->connection->lastInsertId();
    }

    /**
     * Responsible for get a price by his id
     *
     * @param integer $id
     * @return array
     */
    public function getPriceById(int $id): array
    {
        $query = 'SELECT * FROM prices WHERE id = :id LIMIT 1';
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $price = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $price;
    }
}