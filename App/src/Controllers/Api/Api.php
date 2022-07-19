<?php

declare(strict_types=1);

namespace Inventory\Controllers\Api;

use Inventory\Http\Request;
use Inventory\Services\PaginationService;

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

    /**
     * Responsible for return the pagination details
     *
     * @param Request $request
     * @return array
     */
    protected static function getPagination(
        Request $request,
        PaginationService $paginationService
    ): array {
        // Query params
        $queryParams = $request->getQueryParams();

        // Pages
        $pages = $paginationService->getPages();

        return [
            'currentPAge' => isset($queryParams['page']) ? $queryParams['page'] : 1,
            'amountOfPages' => !empty($pages) ? count($pages) : 1
        ];
    }
}
