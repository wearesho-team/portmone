<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification\Collections;

use Wearesho\Bobra\Portmone\Direct\Collections\Payers;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Portmone\Direct\Entities\Company;
use Wearesho\Bobra\Portmone\Direct\Entities\Meter;
use Wearesho\Bobra\Portmone\Direct\Entities\Payer;

/**
 * Class PayersTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct\Collections
 * @internal
 */
class PayersTest extends TestCase
{
    /** @var Payers */
    protected $payers;

    protected function setUp(): void
    {
        $this->payers = new Payers([
            new Payer('123'),
            new Payer('321'),
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Element must be instance of Wearesho\Bobra\Portmone\Direct\Entities\Payer
     */
    public function testAppendInvalidElement(): void
    {
        $this->payers->append(new Company('testName', 'testCode'));
    }

    public function testAppendCorrectElement(): void
    {
        $payer = new Payer('456');
        $this->payers->append($payer);
        $this->assertEquals($payer, $this->payers->offsetGet(2));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Element must be instance of Wearesho\Bobra\Portmone\Direct\Entities\Payer
     */
    public function testSetInvalidElement(): void
    {
        $this->payers->offsetSet(0, new Company('testName', 'testCode'));
    }

    public function testSetCorrectElement(): void
    {
        $payer = new Payer('789');
        $this->payers->offsetSet(0, $payer);
        $this->assertEquals($payer, $this->payers->offsetGet(0));
    }
}
