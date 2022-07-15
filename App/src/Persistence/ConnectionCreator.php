<?php

declare(strict_types=1);

namespace Inventory\Persistence;

use Exception;
use Inventory\Config;
use PDO;

class ConnectionCreator
{
    public static function createConnection(): PDO
    {
        $dsn = 'mysql:host=' . Config::DB_HOST . ';port=' . Config::DB_PORT .
            ';dbname=' . Config::DB_NAME;

        try {
            $connection = new PDO(
                $dsn,
                Config::DB_USER,
                Config::DB_PASSWORD
            );

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo("Can't open the database.");
        }

        return $connection;
    }
}