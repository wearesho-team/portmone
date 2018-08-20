<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct;

use Carbon\Carbon;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\BankPayment;
use Wearesho\Bobra\Portmone\Direct\Entities;
use Wearesho\Bobra\Portmone\Direct\Collections;

/**
 * Class BankPaymentTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct
 * @coversDefaultClass \Wearesho\Bobra\Portmone\Direct\BankPayment
 * @internal
 */
class BankPaymentTest extends TestCase
{
    protected const DATE = '2018-09-09';
    protected const NUMBER = '120985735';
    protected const ORDER_ID = 26792;
    protected const ORDER_AMOUNT = 138.85;
    protected const COMPANY_NAME = 'ПАТ «Березка»';
    protected const COMPANY_CODE = '1001';
    protected const BANK_NAME = 'АТ "Банк "Фінанси та Кредит"';
    protected const BANK_CODE = '300131';
    protected const BANK_ACCOUNT = '29244020902980';
    protected const BILL_ID = 14561;
    protected const BILL_PERIOD = '0110';
    protected const BILL_SET_DATE = '2018-03-12';
    protected const DEBT = 0;
    protected const AMOUNT = 120.35;
    protected const AUTH_CODE = '739280';
    protected const COMMISSION = 0;
    protected const PAYER_CONTRACT_NUMBER = '08967563';
    protected const PAYER_ATTRIBUTES = ['ATTRIBUTE1' => '12082010',];
    protected const PAYMENT_DATE = '2010-02-15';

    /** @var BankPayment */
    protected $fakeBankPayment;

    protected function setUp(): void
    {
        $this->fakeBankPayment = new BankPayment(
            new Entities\PayOrder(
                static::ORDER_ID,
                Carbon::parse(static::DATE),
                static::NUMBER,
                static::ORDER_AMOUNT
            ),
            new Entities\Company(
                static::COMPANY_NAME,
                static::COMPANY_CODE
            ),
            new Entities\Bank(
                static::BANK_NAME,
                static::BANK_CODE,
                static::BANK_ACCOUNT
            ),
            new Collections\OrderBills([
                new Entities\OrderBill(
                    static::BILL_ID,
                    static::BILL_PERIOD,
                    Carbon::parse(static::PAYMENT_DATE),
                    static::COMMISSION,
                    static::AUTH_CODE,
                    new Entities\Payer(
                        static::PAYER_CONTRACT_NUMBER,
                        static::PAYER_ATTRIBUTES
                    ),
                    static::NUMBER,
                    Carbon::parse(static::BILL_SET_DATE),
                    static::AMOUNT,
                    static::DEBT
                )
            ])
        );
    }

    public function testGetPayOrder(): void
    {
        $this->assertEquals(
            new Entities\PayOrder(
                static::ORDER_ID,
                Carbon::parse(static::DATE),
                static::NUMBER,
                static::ORDER_AMOUNT
            ),
            $this->fakeBankPayment->getPayOrder()
        );
    }

    public function testGetPayee(): void
    {
        $this->assertEquals(
            static::COMPANY_CODE,
            $this->fakeBankPayment->getPayee()
        );
    }

    public function testGetCompany(): void
    {
        $this->assertEquals(
            new Entities\Company(
                static::COMPANY_NAME,
                static::COMPANY_CODE
            ),
            $this->fakeBankPayment->getCompany()
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
            $this->fakeBankPayment->getBank()
        );
    }

    public function testGetBills(): void
    {
        $this->assertEquals(
            new Collections\OrderBills([
                new Entities\OrderBill(
                    static::BILL_ID,
                    static::BILL_PERIOD,
                    Carbon::parse(static::PAYMENT_DATE),
                    static::COMMISSION,
                    static::AUTH_CODE,
                    new Entities\Payer(
                        static::PAYER_CONTRACT_NUMBER,
                        static::PAYER_ATTRIBUTES
                    ),
                    static::NUMBER,
                    Carbon::parse(static::BILL_SET_DATE),
                    static::AMOUNT,
                    static::DEBT
                )
            ]),
            $this->fakeBankPayment->getBills()
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
                        'id' => static::BILL_ID,
                        'number' => static::NUMBER,
                        'billDate' => static::BILL_SET_DATE,
                        'payDate' => static::PAYMENT_DATE,
                        'period' => static::BILL_PERIOD,
                        'amount' => static::AMOUNT,
                        'commission' => static::COMMISSION,
                        'debt' => static::DEBT,
                        'authCode' => static::AUTH_CODE,
                        'payer' => [
                            'contractNumber' => static::PAYER_CONTRACT_NUMBER,
                            'attributes' => static::PAYER_ATTRIBUTES
                        ],
                    ],
                ],
            ],
            $this->fakeBankPayment->jsonSerialize()
        );
    }
}
