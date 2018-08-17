<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification;

use Carbon\Carbon;

use Wearesho\Bobra\Portmone\Notification\InternalPayment;
use Wearesho\Bobra\Portmone\Notification\Entities;

/**
 * Class SystemPaymentTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Notification
 * @internal
 */
class SystemPaymentTest extends PaymentTestCase
{
    /** @var InternalPayment */
    protected $payment;

    protected function setUp()
    {
        parent::setUp();

        $this->payment = new InternalPayment(
            $this->companyData,
            $this->bankData,
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
                new Entities\PayerData(
                    static::PAYER_CONTRACT_NUMBER,
                    static::PAYER_ATTRIBUTES
                ),
                $this->meters
            )
        );
    }

    public function testGetBill(): void
    {
        $this->assertEquals(
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
                new Entities\PayerData(
                    static::PAYER_CONTRACT_NUMBER,
                    static::PAYER_ATTRIBUTES
                ),
                $this->meters
            ),
            $this->payment->getBill()
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'company' => [
                    'name' => static::COMPANY_NAME,
                    'code' => static::COMPANY_CODE,
                ],
                'bank' => [
                    'name' => static::BANK_NAME,
                    'code' => static::BANK_CODE,
                    'account' => static::BANK_ACCOUNT,
                ],
                'bill' => [
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
            $this->payment->jsonSerialize()
        );
    }
}
