<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification;

use Carbon\Carbon;

use Wearesho\Bobra\Portmone\Notification\SystemPayment;
use Wearesho\Bobra\Portmone\Notification\Entities;
use Wearesho\Bobra\Portmone\Notification\Collections;

use PHPUnit\Framework\TestCase;

/**
 * Class SystemPaymentTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Notification
 * @internal
 */
class SystemPaymentTest extends TestCase
{
    protected const ID = 14561;
    protected const DEBT = 0;
    protected const AMOUNT = 120.35;
    protected const AUTH_CODE = '739280';
    protected const COMMISSION = 0;
    protected const COMPANY_NAME = 'ПАТ «Березка»';
    protected const COMPANY_CODE = '1001';
    protected const BANK_NAME = 'АТ "Банк "Фінанси та Кредит"';
    protected const BANK_CODE = '300131';
    protected const BANK_ACCOUNT = '29244020902980';
    protected const BILL_NUMBER = '3892/1';
    protected const BILL_DATE = '2010-02-01';
    protected const BILL_PERIOD = '0110';
    protected const PAYMENT_DATE = '2010-02-15';
    protected const PAYER_CONTRACT_NUMBER = '08967563';
    protected const PAYER_ATTRIBUTES = ['ATTRIBUTE1' => '12082010'];

    /** @var SystemPayment */
    protected $systemPayment;

    protected function setUp()
    {
        $this->systemPayment = new SystemPayment(
            new Entities\CompanyData(
                static::COMPANY_NAME,
                static::COMPANY_CODE
            ),
            new Entities\BankData(
                static::BANK_NAME,
                static::BANK_CODE,
                static::BANK_ACCOUNT
            ),
            new Entities\BillData(
                static::ID,
                static::BILL_NUMBER,
                Carbon::parse(static::BILL_DATE),
                static::BILL_PERIOD
            ),
            Carbon::parse(static::PAYMENT_DATE),
            static::AMOUNT,
            static::COMMISSION,
            static::DEBT,
            static::AUTH_CODE,
            new Collections\Payers([
                new Entities\PayerData(
                    static::PAYER_CONTRACT_NUMBER,
                    static::PAYER_ATTRIBUTES
                )
            ]),
            new Collections\Meters()
        );
    }

    public function testGetPayee(): void
    {
        $this->assertEquals(
            static::COMPANY_CODE,
            $this->systemPayment->getPayee()
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals(
            static::ID,
            $this->systemPayment->getId()
        );
    }

    public function testGetBank(): void
    {
        $this->assertEquals(
            new Entities\BankData(
                static::BANK_NAME,
                static::BANK_CODE,
                static::BANK_ACCOUNT
            ),
            $this->systemPayment->getBank()
        );
    }

    public function testGetMeters(): void
    {
        $this->assertEmpty($this->systemPayment->getMeters());
    }

    public function testGetCompany(): void
    {
        $this->assertEquals(
            new Entities\CompanyData(
                static::COMPANY_NAME,
                static::COMPANY_CODE
            ),
            $this->systemPayment->getCompany()
        );
    }

    public function testGetDate(): void
    {
        $this->assertEquals(
            Carbon::parse(static::PAYMENT_DATE),
            Carbon::instance($this->systemPayment->getDate())
        );
    }

    public function testGetDebt(): void
    {
        $this->assertEquals(
            static::DEBT,
            $this->systemPayment->getDebt()
        );
    }

    public function testGetAmount(): void
    {
        $this->assertEquals(
            static::AMOUNT,
            $this->systemPayment->getAmount()
        );
    }

    public function testGetAuthCode(): void
    {
        $this->assertEquals(
            static::AUTH_CODE,
            $this->systemPayment->getAuthCode()
        );
    }

    public function testGetCommission(): void
    {
        $this->assertEquals(
            static::COMMISSION,
            $this->systemPayment->getCommission()
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
                    'date' => static::BILL_DATE,
                    'period' => static::BILL_PERIOD
                ],
                'date' => static::PAYMENT_DATE,
                'amount' => static::AMOUNT,
                'commission' => static::COMMISSION,
                'debt' => static::DEBT,
                'authCode' => static::AUTH_CODE,
                'payers' => [
                    [
                        'contractNumber' => static::PAYER_CONTRACT_NUMBER,
                        'attributes' => static::PAYER_ATTRIBUTES
                    ]
                ],
                'meters' => []
            ],
            $this->systemPayment->jsonSerialize()
        );
    }

    public function testGetBill(): void
    {
        $this->assertEquals(
            new Entities\BillData(
                static::ID,
                static::BILL_NUMBER,
                Carbon::parse(static::BILL_DATE),
                static::BILL_PERIOD
            ),
            $this->systemPayment->getBill()
        );
    }

    public function testGetPayers(): void
    {
        $this->assertEquals(
            new Collections\Payers([
                new Entities\PayerData(
                    static::PAYER_CONTRACT_NUMBER,
                    static::PAYER_ATTRIBUTES
                )
            ]),
            $this->systemPayment->getPayers()
        );
    }
}
