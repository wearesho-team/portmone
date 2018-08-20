<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct;

use Carbon\Carbon;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Entities;
use Wearesho\Bobra\Portmone\Direct\InternalPaymentNotification;

/**
 * Class InternalPaymentNotificationTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct
 * @coversDefaultClass InternalPaymentNotification
 * @internal
 */
class InternalPaymentNotificationTest extends TestCase
{
    protected const COMPANY_NAME = 'companyName';
    protected const COMPANY_CODE = '123456';
    protected const BANK_NAME = 'bankName';
    protected const BANK_CODE = 'bankCode';
    protected const BANK_ACCOUNT = 'bankAccount';
    protected const ID = 123;
    protected const NUMBER = '123123123';
    protected const SET_DATE = '2018-03-12';
    protected const PAY_DATE = '2018-03-25';
    protected const PERIOD = '0110';
    protected const AMOUNT = 120.56;
    protected const COMMISSION = 13.35;
    protected const DEBT = 25.43;
    protected const AUTH_CODE = '123456';

    protected const PAYER_CONTRACT_NUMBER = '123456789';
    
    /** @var InternalPaymentNotification */
    protected $fakeInternalPaymentNotification;
    
    protected function setUp(): void
    {
        $this->fakeInternalPaymentNotification = new InternalPaymentNotification(
            new Entities\InternalBill(
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
            )
        );
    }

    public function testGetBill(): void
    {
        $this->assertEquals(
            new Entities\InternalBill(
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
            ),
            $this->fakeInternalPaymentNotification->getBill()
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals(
            static::ID,
            $this->fakeInternalPaymentNotification->getId()
        );
    }

    public function testGetPayee(): void
    {
        $this->assertEquals(
            static::COMPANY_CODE,
            $this->fakeInternalPaymentNotification->getPayee()
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'bill' => [
                    'company' => [
                        'name' => static::COMPANY_NAME,
                        'code' => static::COMPANY_CODE,
                    ],
                    'bank' => [
                        'name' => static::BANK_NAME,
                        'code' => static::BANK_CODE,
                        'account' => static::BANK_ACCOUNT,
                    ],
                    'id' => static::ID,
                    'period' => static::PERIOD,
                    'payDate' => static::PAY_DATE,
                    'commission' => static::COMMISSION,
                    'authCode' => static::AUTH_CODE,
                    'payer' => [
                        'contractNumber' => static::PAYER_CONTRACT_NUMBER,
                    ],
                    'number' => static::NUMBER,
                    'billDate' => static::SET_DATE,
                    'amount' => static::AMOUNT,
                    'debt' => static::DEBT
                ],
            ],
            $this->fakeInternalPaymentNotification->jsonSerialize()
        );
    }
}
