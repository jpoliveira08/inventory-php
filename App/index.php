<?php

declare(strict_types=1);

use Inventory\Controllers\HomeController;
use Inventory\Http\Response;
use Inventory\Http\Router;

require_once __DIR__ . "/vendor/autoload.php";

define('URL_BASE', 'http://localhost:9000');

$router = new Router(URL_BASE);

// Including routes of pages
include __DIR__ . '/routes/pages.php';

// Including routes of API
include __DIR__ . '/routes/api.php';

$router->run()->sendResponse();
