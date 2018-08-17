<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities;

use Carbon\Carbon;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Notification\Entities\PayOrderData;

/**
 * Class PayOrderDataTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities
 * @internal
 */
class PayOrderDataTest extends TestCase
{
    protected const DATE = '2018-09-09';
    protected const NUMBER = '120985735';
    protected const ID = 26792;
    protected const AMOUNT = 138.85;

    /** @var PayOrderData */
    protected $payOrder;

    protected function setUp()
    {
        $this->payOrder = new PayOrderData(
            static::ID,
            Carbon::parse(static::DATE),
            static::NUMBER,
            static::AMOUNT
        );
    }

    public function testGetNumber(): void
    {
        $this->assertEquals(
            static::NUMBER,
            $this->payOrder->getNumber()
        );
    }

    public function testGetDate(): void
    {
        $this->assertEquals(
            Carbon::parse(static::DATE),
            Carbon::instance($this->payOrder->getDate())
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals(
            static::ID,
            $this->payOrder->getId()
        );
    }

    public function testGetAmount(): void
    {
        $this->assertEquals(
            static::AMOUNT,
            $this->payOrder->getAmount()
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'id' => static::ID,
                'date' => static::DATE,
                'number' => static::NUMBER,
                'amount' => static::AMOUNT,
            ],
            $this->payOrder->jsonSerialize()
        );
    }
}
