<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification;

use Carbon\Carbon;

use Wearesho\Bobra\Portmone\Direct\BankPayment;
use Wearesho\Bobra\Portmone\Direct\Entities;
use Wearesho\Bobra\Portmone\Direct\Collections;

/**
 * Class BankPaymentTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct
 * @internal
 */
class BankPaymentTest extends PaymentTestCase
{
    protected const DATE = '2018-09-09';
    protected const NUMBER = '120985735';
    protected const ORDER_ID = 26792;
    protected const ORDER_AMOUNT = 138.85;

    /** @var BankPayment */
    protected $payment;

    protected function setUp()
    {
        parent::setUp();

        $this->payment = new BankPayment(
            new Entities\PayOrderData(
                static::ORDER_ID,
                Carbon::parse(static::DATE),
                static::NUMBER,
                static::ORDER_AMOUNT
            ),
            $this->companyData,
            $this->bankData,
            new Collections\Bills([
                new Entities\BillData(
                    static::ID,
                    static::BILL_NUMBER,
                    Carbon::parse(static::BILL_DATE),
                    Carbon::parse(static::PAYMENT_DATE),
                    static::BILL_PERIOD,
                    static::AMOUNT,
                    static::COMMISSION,
                    static::DEBT,
                    static::AUTH_CODE,
                    new Entities\Payer(
                        static::PAYER_CONTRACT_NUMBER,
                        static::PAYER_ATTRIBUTES
                    ),
                    $this->meters
                )
            ])
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals(
            static::ORDER_ID,
            $this->payment->getId()
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'payOrder' => [
                    'id' => static::ORDER_ID,
                    'date' => static::DATE,
                    'number' => static::NUMBER,
                    'amount' => static::ORDER_AMOUNT,
                ],
                'company' => [
                    'name' => static::COMPANY_NAME,
                    'code' => static::COMPANY_CODE,
                ],
                'bank' => [
                    'name' => static::BANK_NAME,
                    'code' => static::BANK_CODE,
                    'account' => static::BANK_ACCOUNT,
                ],
                'bills' => [
                    [
                        'id' => static::ID,
                        'number' => static::BILL_NUMBER,
                        'billDate' => static::BILL_DATE,
                        'payDate' => static::PAYMENT_DATE,
                        'period' => static::BILL_PERIOD,
                        'amount' => static::AMOUNT,
                        'commission' => static::COMMISSION,
                        'payedDebt' => static::DEBT,
                        'authCode' => static::AUTH_CODE,
                        'payer' => [
                            'contractNumber' => static::PAYER_CONTRACT_NUMBER,
                            'attributes' => static::PAYER_ATTRIBUTES
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
                        ],
                    ],
                ],
            ],
            $this->payment->jsonSerialize()
        );
    }
}
