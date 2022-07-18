<?php

declare(strict_types=1);

namespace Inventory\Interfaces;

interface PriceRepositoryInterface
{
    public function createPrice(array $priceDetails);
    public function getPriceById(int $id);
    public function updatePrice(array $newPriceDetails): bool;
}
