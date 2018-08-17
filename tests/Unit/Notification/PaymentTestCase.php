<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification;

use Carbon\Carbon;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Payment;
use Wearesho\Bobra\Portmone\Direct\PaymentInterface;
use Wearesho\Bobra\Portmone\Direct\Entities;
use Wearesho\Bobra\Portmone\Direct\Collections;

/**
 * Class PaymentTestCase
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct
 */
abstract class PaymentTestCase extends TestCase
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
    protected const PAYER_ATTRIBUTES = ['ATTRIBUTE1' => '12082010',];
    protected const METER_TYPE = 'type';
    protected const METER_CURRENT_COUNTER = '123456';
    protected const METER_PREVIOUS_COUNTER = '123123';
    protected const METER_SUBSIDY = 10;
    protected const METER_DEBT = 20;
    protected const METER_AMOUNT = 200.45;
    
    /** @var Payment */
    protected $payment;
    
    /** @var Entities\CompanyData */
    protected $companyData;
    
    /** @var Entities\BankData */
    protected $bankData;

    /** @var Collections\Payers */
    protected $payers;
    
    /** @var Collections\Meters */
    protected $meters;
    
    protected function setUp()
    {
        $this->companyData = new Entities\CompanyData(
            static::COMPANY_NAME,
            static::COMPANY_CODE
        );
        $this->bankData = new Entities\BankData(
            static::BANK_NAME,
            static::BANK_CODE,
            static::BANK_ACCOUNT
        );
        $this->meters = new Collections\Meters([
            new Entities\MeterData(
                static::METER_TYPE,
                static::METER_CURRENT_COUNTER,
                static::METER_PREVIOUS_COUNTER,
                static::METER_SUBSIDY,
                static::METER_DEBT,
                static::METER_AMOUNT
            )
        ]);
    }

    public function testGetPayee(): void
    {
        $this->assertEquals(
            static::COMPANY_CODE,
            $this->payment->getPayee()
        );
    }

    public function testGetCompany(): void
    {
        $this->assertEquals(
            new Entities\CompanyData(
                static::COMPANY_NAME,
                static::COMPANY_CODE
            ),
            $this->payment->getCompany()
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
            $this->payment->getBank()
        );
    }
}
