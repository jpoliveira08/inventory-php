<?php

declare(strict_types=1);

namespace Inventory\Controllers\Api;

use Inventory\Http\Request;

class Api
{
    /**
     * Responsible for return the API details
     *
     * @param Request $request
     * @return array
     */
    public static function getDetails(Request $request): array
    {
        return [
            'name' => 'API - Product Inventory',
            'version' => 'v1.0.0',
            'author' => 'github.com/jpoliveira08',
            'email' => 'joaopedro.oliveirajava@gmail.com'
        ];
    }

    
}
