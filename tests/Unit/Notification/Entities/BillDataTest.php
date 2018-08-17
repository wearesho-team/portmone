<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities;

use Carbon\Carbon;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Collections\Meters;
use Wearesho\Bobra\Portmone\Direct\Entities;

/**
 * Class BillDataTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities
 * @internal
 */
class BillDataTest extends TestCase
{
    protected const ID = 123;
    protected const NUMBER = '123123123';
    protected const BILL_DATE = '2018-03-12';
    protected const PAY_DATE = '2018-03-25';
    protected const PERIOD = '0110';
    protected const AMOUNT = 120.56;
    protected const COMMISSION = 13.35;
    protected const DEBT = 25.43;
    protected const AUTH_CODE = '123456';

    protected const PAYER_CONTRACT_NUMBER = '123456789';

    protected const METER_TYPE = 'type';
    protected const METER_CURRENT_COUNTER = '123456';
    protected const METER_PREVIOUS_COUNTER = '123123';
    protected const METER_SUBSIDY = 10.56;
    protected const METER_DEBT = 12.10;
    protected const METER_AMOUNT = 200.30;

    /** @var Entities\BillData */
    protected $billData;

    protected function setUp(): void
    {
        $this->billData = new Entities\BillData(
            static::ID,
            static::NUMBER,
            Carbon::parse(static::BILL_DATE),
            Carbon::parse(static::PAY_DATE),
            static::PERIOD,
            static::AMOUNT,
            static::COMMISSION,
            static::DEBT,
            static::AUTH_CODE,
            new Entities\PayerData(static::PAYER_CONTRACT_NUMBER),
            new Meters([
                new Entities\MeterData(
                    static::METER_TYPE,
                    static::METER_CURRENT_COUNTER,
                    static::METER_PREVIOUS_COUNTER,
                    static::METER_SUBSIDY,
                    static::METER_DEBT,
                    static::METER_AMOUNT
                )
            ])
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'id' => static::ID,
                'number' => static::NUMBER,
                'billDate' => static::BILL_DATE,
                'payDate' => static::PAY_DATE,
                'period' => static::PERIOD,
                'amount' => static::AMOUNT,
                'commission' => static::COMMISSION,
                'payedDebt' => static::DEBT,
                'authCode' => static::AUTH_CODE,
                'payer' => [
                    'contractNumber' => static::PAYER_CONTRACT_NUMBER,
                ],
                'meters' => [
                    [
                        'type' => static::METER_TYPE,
                        'counter' => [
                            'current' => static::METER_CURRENT_COUNTER,
                            'previous' => static::METER_PREVIOUS_COUNTER,
                        ],
                        'subsidy' => static::METER_SUBSIDY,
                        'debt' => static::METER_DEBT,
                        'amount' => static::METER_AMOUNT,
                    ]
                ]
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

    public function testGetBillDate(): void
    {
        $this->assertEquals(
            Carbon::parse(static::BILL_DATE),
            Carbon::instance($this->billData->getBillDate())
        );
    }

    public function testGetPayDate(): void
    {
        $this->assertEquals(
            Carbon::parse(static::PAY_DATE),
            Carbon::instance($this->billData->getPayDate())
        );
    }

    public function testGetPeriod(): void
    {
        $this->assertEquals(
            static::PERIOD,
            $this->billData->getPeriod()
        );
    }

    public function testGetPayedAmount(): void
    {
        $this->assertEquals(
            static::AMOUNT,
            $this->billData->getPayedAmount()
        );
    }

    public function testGetPayedCommission(): void
    {
        $this->assertEquals(
            static::COMMISSION,
            $this->billData->getPayedCommission()
        );
    }

    public function testGetPayedDebt(): void
    {
        $this->assertEquals(
            static::DEBT,
            $this->billData->getPayedDebt()
        );
    }

    public function testGetAuthCode(): void
    {
        $this->assertEquals(
            static::AUTH_CODE,
            $this->billData->getAuthCode()
        );
    }

    public function testGetPayer(): void
    {
        $this->assertEquals(
            new Entities\PayerData(static::PAYER_CONTRACT_NUMBER),
            $this->billData->getPayer()
        );
    }

    public function testGetMeters(): void
    {
        $this->assertEquals(
            new Meters([
                new Entities\MeterData(
                    static::METER_TYPE,
                    static::METER_CURRENT_COUNTER,
                    static::METER_PREVIOUS_COUNTER,
                    static::METER_SUBSIDY,
                    static::METER_DEBT,
                    static::METER_AMOUNT
                )
            ]),
            $this->billData->getMeters()
        );
    }
}
