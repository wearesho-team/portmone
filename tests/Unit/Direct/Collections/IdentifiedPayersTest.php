<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct\Collections;

use Carbon\Carbon;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Collections\IdentifiedPayers;
use Wearesho\Bobra\Portmone\Direct\Entities;

/**
 * Class IdentifiedPayersTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct\Collections
 * @coversDefaultClass IdentifiedPayers
 * @internal
 */
class IdentifiedPayersTest extends TestCase
{
    protected const PERIOD = '0110';
    protected const CONTRACT_NUMBER = '123456789';
    protected const BILL_NUMBER = '123456789';
    protected const BILL_SET_DATE = '2018-03-12';
    protected const AMOUNT = 123.45;
    protected const DEBT = 234.56;

    /** @var IdentifiedPayers */
    protected $fakeIdentifiedPayers;

    protected function setUp(): void
    {
        $this->fakeIdentifiedPayers = new IdentifiedPayers(
            static::PERIOD,
            [
                new Entities\IdentifiedPayer(
                    new Entities\Payer(static::CONTRACT_NUMBER),
                    static::BILL_NUMBER,
                    Carbon::parse(static::BILL_SET_DATE),
                    static::AMOUNT,
                    static::DEBT
                )
            ]
        );
    }

    public function testGetPeriod(): void
    {
        $this->assertEquals(
            static::PERIOD,
            $this->fakeIdentifiedPayers->getPeriod()
        );
    }
}
