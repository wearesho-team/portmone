<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities;

use Wearesho\Bobra\Portmone\Notification\Entities\MeterData;

use PHPUnit\Framework\TestCase;

/**
 * Class MeterDataTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities
 * @internal
 */
class MeterDataTest extends TestCase
{
    protected const DEBT = 123;
    protected const CURRENT_COUNTER = '23456';
    protected const PREVIOUS_COUNTER = '12345';
    protected const SUBSIDY = 10;
    protected const TYPE = 'testType';
    protected const AMOUNT = 123.56;

    /** @var MeterData */
    protected $meterData;

    protected function setUp(): void
    {
        $this->meterData = new MeterData(
            static::TYPE,
            static::CURRENT_COUNTER,
            static::PREVIOUS_COUNTER,
            static::SUBSIDY,
            static::DEBT,
            static::AMOUNT
        );
    }

    public function testGetDebt(): void
    {
        $this->assertEquals(
            static::DEBT,
            $this->meterData->getDebt()
        );
    }

    public function testGetCurrentCounter(): void
    {
        $this->assertEquals(
            static::CURRENT_COUNTER,
            $this->meterData->getCurrentCounter()
        );
    }

    public function testGetSubsidy(): void
    {
        $this->assertEquals(
            static::SUBSIDY,
            $this->meterData->getSubsidy()
        );
    }

    public function testGetType(): void
    {
        $this->assertEquals(
            static::TYPE,
            $this->meterData->getType()
        );
    }

    public function testGetAmount(): void
    {
        $this->assertEquals(
            static::AMOUNT,
            $this->meterData->getAmount()
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'type' => static::TYPE,
                'counter' => [
                    'current' => static::CURRENT_COUNTER,
                    'previous' => static::PREVIOUS_COUNTER,
                ],
                'subsidy' => static::SUBSIDY,
                'debt' => static::DEBT,
                'amount' => static::AMOUNT,
            ],
            $this->meterData->jsonSerialize()
        );
    }

    public function testGetPreviousCounter(): void
    {
        $this->assertEquals(
            static::PREVIOUS_COUNTER,
            $this->meterData->getPreviousCounter()
        );
    }
}
