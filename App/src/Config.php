<?php

declare(strict_types=1);

namespace Inventory;

class Config
{
    /** @var string DB_HOST contains database host from the database container */
    const DB_HOST = 'database';

    /** @var string DB_NAME contains database name */
    const DB_NAME = 'inventory';

    /** @var string DB_PORT contains database port */
    const DB_PORT = '3306';

    /** @var string DB_NAME contains database user */
    const DB_USER = 'root';

    /** @var string DB_PASSWORD contains database password */
    const DB_PASSWORD = 'root';
}