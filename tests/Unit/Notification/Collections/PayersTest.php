<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification\Collections;

use Wearesho\Bobra\Portmone\Notification\Collections\Payers;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Portmone\Notification\Entities\CompanyData;
use Wearesho\Bobra\Portmone\Notification\Entities\MeterData;
use Wearesho\Bobra\Portmone\Notification\Entities\PayerData;

/**
 * Class PayersTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Notification\Collections
 * @internal
 */
class PayersTest extends TestCase
{
    /** @var Payers */
    protected $payers;

    protected function setUp(): void
    {
        $this->payers = new Payers([
            new PayerData('123'),
            new PayerData('321'),
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Element must be instance of Wearesho\Bobra\Portmone\Notification\Entities\PayerData
     */
    public function testAppendInvalidElement(): void
    {
        $this->payers->append(new CompanyData('testName', 'testCode'));
    }

    public function testAppendCorrectElement(): void
    {
        $payer = new PayerData('456');
        $this->payers->append($payer);
        $this->assertEquals($payer, $this->payers->offsetGet(2));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Element must be instance of Wearesho\Bobra\Portmone\Notification\Entities\PayerData
     */
    public function testSetInvalidElement(): void
    {
        $this->payers->offsetSet(0, new CompanyData('testName', 'testCode'));
    }

    public function testSetCorrectElement(): void
    {
        $payer = new PayerData('789');
        $this->payers->offsetSet(0, $payer);
        $this->assertEquals($payer, $this->payers->offsetGet(0));
    }
}
