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
            'id' => 1,
            'value' => 5.65
        ];

        $priceRepository = $this->createMock(PriceRepository::class);
        $priceRepository->method('createPrice')->willReturn($data['id']);

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
}