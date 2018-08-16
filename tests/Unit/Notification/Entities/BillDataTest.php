<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities;

use Carbon\Carbon;

use Wearesho\Bobra\Portmone\Notification\Entities\BillData;

use PHPUnit\Framework\TestCase;

/**
 * Class BillDataTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities
 * @internal
 */
class BillDataTest extends TestCase
{
    protected const ID = 123;
    protected const NUMBER = '123123123';
    protected const DATE = '2018-03-12';
    protected const PERIOD = '0110';

    /** @var BillData */
    protected $billData;

    protected function setUp(): void
    {
        $this->billData = new BillData(
            static::ID,
            static::NUMBER,
            Carbon::parse(static::DATE),
            static::PERIOD
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'id' => static::ID,
                'number' => static::NUMBER,
                'date' => static::DATE,
                'period' => static::PERIOD
            ],
            $this->billData->jsonSerialize()
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals(
            static::ID,
            $this->billData->getId()
        );
    }

    public function testGetNumber(): void
    {
        $this->assertEquals(
            static::NUMBER,
            $this->billData->getNumber()
        );
    }

    public function testGetDate(): void
    {
        $this->assertEquals(
            Carbon::parse(static::DATE),
            Carbon::instance($this->billData->getDate())
        );
    }

    public function testGetPeriod(): void
    {
        $this->assertEquals(
            static::PERIOD,
            $this->billData->getPeriod()
        );
    }
}
