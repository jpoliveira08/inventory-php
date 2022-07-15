<?php

// For index pages

use Inventory\Controllers\HomeController;
use Inventory\Http\Response;

// get na url, com a closure pega o método no controller
$router->get('/', [
    function () {
        return new Response(200, HomeController::index());
    }
]);
