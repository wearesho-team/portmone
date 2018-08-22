<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities;

use Carbon\Carbon;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Entities;

/**
 * Class InternalBillTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities
 * @coversDefaultClass \Wearesho\Bobra\Portmone\Direct\Entities\InternalBill
 * @internal
 */
class InternalBillTest extends TestCase
{
    protected const ID = 123;
    protected const NUMBER = '123123123';
    protected const SET_DATE = '2018-03-12';
    protected const PAY_DATE = '2018-03-25';
    protected const PERIOD = '0110';
    protected const AMOUNT = 120.56;
    protected const COMMISSION = 13.35;
    protected const DEBT = 25.43;
    protected const AUTH_CODE = '123456';

    protected const COMPANY_NAME = 'companyName';
    protected const COMPANY_CODE = 'companyCode';

    protected const BANK_NAME = 'bankName';
    protected const BANK_CODE = 'bankCode';
    protected const BANK_ACCOUNT = 'bankAccount';

    protected const PAYER_CONTRACT_NUMBER = '123456789';

    /** @var Entities\InternalBill */
    protected $fakeInternalBill;

    protected function setUp(): void
    {
        $this->fakeInternalBill = new Entities\InternalBill(
            static::ID,
            new Entities\Company(
                static::COMPANY_NAME,
                static::COMPANY_CODE
            ),
            new Entities\Bank(
                static::BANK_NAME,
                static::BANK_CODE,
                static::BANK_ACCOUNT
            ),
            static::PERIOD,
            Carbon::parse(static::PAY_DATE),
            static::COMMISSION,
            static::AUTH_CODE,
            new Entities\Payer(static::PAYER_CONTRACT_NUMBER),
            static::NUMBER,
            Carbon::parse(static::SET_DATE),
            static::AMOUNT,
            static::DEBT
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'id' => static::ID,
                'number' => static::NUMBER,
                'billDate' => static::SET_DATE,
                'payDate' => static::PAY_DATE,
                'period' => static::PERIOD,
                'amount' => static::AMOUNT,
                'commission' => static::COMMISSION,
                'debt' => static::DEBT,
                'authCode' => static::AUTH_CODE,
                'payer' => [
                    'contractNumber' => static::PAYER_CONTRACT_NUMBER,
                ],
            ],
            $this->fakeInternalBill->jsonSerialize()
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals(
            static::ID,
            $this->fakeInternalBill->getId()
        );
    }

    public function testGetNumber(): void
    {
        $this->assertEquals(
            static::NUMBER,
            $this->fakeInternalBill->getNumber()
        );
    }

    public function testGetSetDate(): void
    {
        $this->assertEquals(
            Carbon::parse(static::SET_DATE),
            Carbon::instance($this->fakeInternalBill->getSetDate())
        );
    }

    public function testGetPayDate(): void
    {
        $this->assertEquals(
            Carbon::parse(static::PAY_DATE),
            Carbon::instance($this->fakeInternalBill->getPayDate())
        );
    }

    public function testGetPeriod(): void
    {
        $this->assertEquals(
            static::PERIOD,
            $this->fakeInternalBill->getPeriod()
        );
    }

    public function testGetPayedAmount(): void
    {
        $this->assertEquals(
            static::AMOUNT,
            $this->fakeInternalBill->getAmount()
        );
    }

    public function testGetPayedCommission(): void
    {
        $this->assertEquals(
            static::COMMISSION,
            $this->fakeInternalBill->getCommission()
        );
    }

    public function testGetPayedDebt(): void
    {
        $this->assertEquals(
            static::DEBT,
            $this->fakeInternalBill->getDebt()
        );
    }

    public function testGetAuthCode(): void
    {
        $this->assertEquals(
            static::AUTH_CODE,
            $this->fakeInternalBill->getAuthCode()
        );
    }

    public function testGetPayer(): void
    {
        $this->assertEquals(
            new Entities\Payer(static::PAYER_CONTRACT_NUMBER),
            $this->fakeInternalBill->getPayer()
        );
    }

    public function testGetBank(): void
    {
        $this->assertEquals(
            new Entities\Bank(
                static::BANK_NAME,
                static::BANK_CODE,
                static::BANK_ACCOUNT
            ),
            $this->fakeInternalBill->getBank()
        );
    }

    public function testGetCompany(): void
    {
        $this->assertEquals(
            new Entities\Company(
                static::COMPANY_NAME,
                static::COMPANY_CODE
            ),
            $this->fakeInternalBill->getCompany()
        );
    }
}
