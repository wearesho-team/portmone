<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities;

use Carbon\Carbon;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Entities\IdentifiedPayer;
use Wearesho\Bobra\Portmone\Direct\Entities\Payer;

/**
 * Class IdentifiedPayerTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities
 * @coversDefaultClass \Wearesho\Bobra\Portmone\Direct\Entities\Payer
 * @internal
 */
class IdentifiedPayerTest extends TestCase
{
    protected const CONTRACT_NUMBER = '123456789';
    protected const ATTRIBUTES = ['ATTRIBUTE1' => '321654987'];
    protected const BILL_NUMBER = '321456789';
    protected const AMOUNT = 123.45;
    protected const DEBT = 234.56;
    protected const REMARK = 'remark';
    protected const BILL_SET_DATE = '2018-03-12';

    /** @var IdentifiedPayer */
    protected $fakeIdentifiedPayer;

    protected function setUp(): void
    {
        $this->fakeIdentifiedPayer = new IdentifiedPayer(
            new Payer(static::CONTRACT_NUMBER, static::ATTRIBUTES),
            static::BILL_NUMBER,
            Carbon::parse(static::BILL_SET_DATE),
            static::AMOUNT,
            static::DEBT,
            static::REMARK
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'payer' => [
                    'contractNumber' => static::CONTRACT_NUMBER,
                    'attributes' => static::ATTRIBUTES,
                ],
                'number' => static::BILL_NUMBER,
                'billDate' => static::BILL_SET_DATE,
                'amount' => static::AMOUNT,
                'debt' => static::DEBT,
                'remark' => static::REMARK,
            ],
            $this->fakeIdentifiedPayer->jsonSerialize()
        );
    }

    public function testGetRemark(): void
    {
        $this->assertEquals(
            static::REMARK,
            $this->fakeIdentifiedPayer->getRemark()
        );
    }
}
