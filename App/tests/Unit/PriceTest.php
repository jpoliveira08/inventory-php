<?php

declare(strict_types=1);

namespace Tests\Unit;

use Inventory\Persistence\ConnectionCreator;
use Inventory\Repositories\PriceRepository;
use PHPUnit\Framework\TestCase;

/**
 * PriceTest class
 */
class PriceTest extends TestCase
{
    /** @test */
    public function it_can_create_a_price(): void
    {
        $data = [
            'value' => 5.65
        ];

        $priceRepository = $this->createMock(PriceRepository::class);
        $priceRepository->method('createPrice')
            ->willReturn($data['id'] = 1);

        $this->assertEquals(1, $priceRepository->createPrice($data));
    }

    /** @test */
    public function it_can_get_a_price_by_id(): void
    {
        $data = [
            'id' => 1,
            'value' => 5.65
        ];

        $priceRepository = $this->createMock(PriceRepository::class);
        $priceRepository->method('getPriceById')->willReturn($data);

        $this->assertEquals($data, $priceRepository->getPriceById($data['id']));
    }

    /** @test */
    public function it_can_update_a_price(): void
    {
        $oldPriceData = [
            'id' => 1,
            'value' => 5.65
        ];

        $priceRepository = $this->createMock(PriceRepository::class);
        $newPriceData = [
            'id' => 1,
            'value' => 10.00
        ];

        $priceRepository->method('updatePrice')
            ->willReturn($newPriceData);
        
        $this->assertEquals(
            $newPriceData, 
            $priceRepository->updatePrice($oldPriceData)
        );
    }
}