<?php

use Inventory\Http\Response;

// Root api route
$router->get('/api/v1', [
    function ($request) {
        return new Response(200, 'Api');
    }
]);