<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification\Collections;

use Wearesho\Bobra\Portmone\Notification\Collections\Meters;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Portmone\Notification\Entities\CompanyData;
use Wearesho\Bobra\Portmone\Notification\Entities\MeterData;

/**
 * Class MetersTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Notification\Collections
 * @internal
 */
class MetersTest extends TestCase
{
    /** @var Meters */
    protected $meters;

    protected function setUp(): void
    {
        $this->meters = new Meters([
            new MeterData(
                'testType',
                '321',
                '123',
                10,
                10,
                10
            ),
            new MeterData(
                'testType',
                '456',
                '654',
                100,
                200,
                300
            ),
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Element must be instance of Wearesho\Bobra\Portmone\Notification\Entities\MeterData
     */
    public function testAppendInvalidElement(): void
    {
        $this->meters->append(new CompanyData('testName', 'testCode'));
    }

    public function testAppendCorrectElement(): void
    {
        $payer = new MeterData(
            'type',
            '145',
            '098',
            1.12,
            2.43,
            3.9
        );
        $this->meters->append($payer);
        $this->assertEquals($payer, $this->meters->offsetGet(2));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Element must be instance of Wearesho\Bobra\Portmone\Notification\Entities\MeterData
     */
    public function testSetInvalidElement(): void
    {
        $this->meters->offsetSet(0, new CompanyData('testName', 'testCode'));
    }

    public function testSetCorrectElement(): void
    {
        $payer = new MeterData(
            'test',
            '987',
            '678',
            50.45,
            120.50,
            200.96
        );
        $this->meters->offsetSet(0, $payer);
        $this->assertEquals($payer, $this->meters->offsetGet(0));
    }
}
