<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification;

use Carbon\Carbon;

use Wearesho\Bobra\Portmone\Notification\Collections;
use Wearesho\Bobra\Portmone\Notification\Entities;
use Wearesho\Bobra\Portmone\Notification\SystemPayment;
use Wearesho\Bobra\Portmone\Notification\SystemRequest;
use Wearesho\Bobra\Portmone\Notification\Server;

use PHPUnit\Framework\TestCase;

/**
 * Class ServerTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Notification
 *
 * @internal
 */
class ServerTest extends TestCase
{
    /** @var Server */
    protected $server;

    protected function setUp(): void
    {
        $this->server = new Server();
    }

    public function testSystemRequestHandle(): void
    {
        $data = '<?xml version="1.0" encoding="UTF-8"?>
            <REQUESTS>
                <PAYEE>1001</PAYEE>
                <PAYER>
                    <CONTRACT_NUMBER>08967563</CONTRACT_NUMBER>
                    <ATTRIBUTE1>12082010</ATTRIBUTE1>
                </PAYER>
                <PAYER>
                    <CONTRACT_NUMBER>03567892</CONTRACT_NUMBER>
                    <ATTRIBUTE1>11052009</ATTRIBUTE1>
                    <ATTRIBUTE2>11057892</ATTRIBUTE2>
                </PAYER>
            </REQUESTS>';

        /** @noinspection PhpUnhandledExceptionInspection */
        /** @var SystemRequest $notification */
        $notification = $this->server->handle($data);

        $this->assertInstanceOf(SystemRequest::class, $notification);
        $this->assertEquals('1001', $notification->getPayee());
        $this->assertEquals(
            new Collections\Payers([
                new Entities\PayerData(
                    '08967563',
                    [
                        'ATTRIBUTE1' => '12082010',
                    ]
                ),
                new Entities\PayerData(
                    '03567892',
                    [
                        'ATTRIBUTE1' => '11052009',
                        'ATTRIBUTE2' => '11057892',
                    ]
                ),
            ]),
            $notification->getPayers()
        );
    }

    public function testSystemPaymentHandle(): void
    {
        $data = '<?xml version="1.0" encoding="UTF-8"?>
            <BILLS>
                <BILL>
                    <PAYEE>
                        <NAME>ПАТ «Березка»</NAME> 
                        <CODE>1001</CODE> 
                    </PAYEE>
                    <BANK>
                        <NAME>АТ "Банк "Фінанси та Кредит"</NAME> 
                        <CODE>300131</CODE> 
                        <ACCOUNT>29244020902980</ACCOUNT> 
                    </BANK>
                    <BILL_ID>14561</BILL_ID> 
                    <BILL_NUMBER>3892/1</BILL_NUMBER> 
                    <BILL_DATE>2010-02-01</BILL_DATE> 
                    <BILL_PERIOD>0110</BILL_PERIOD> 
                    <PAY_DATE>2010-02-15</PAY_DATE> 
                    <PAYED_AMOUNT>120.35</PAYED_AMOUNT> 
                    <PAYED_COMMISSION>0</PAYED_COMMISSION> 
                    <PAYED_DEBT>0</PAYED_DEBT> 
                    <AUTH_CODE>739280</AUTH_CODE> 
                    <PAYER>
                        <CONTRACT_NUMBER>08967563</CONTRACT_NUMBER>
                        <ATTRIBUTE1>12082010</ATTRIBUTE1>
                    </PAYER>
                    <ITEMS>
                        <ITEM>
                            <ITEM_TYPE>testType</ITEM_TYPE>
                            <ITEM_AMOUNT>120.56</ITEM_AMOUNT>
                            <ITEM_SUBSIDY>10</ITEM_SUBSIDY>
                            <ITEM_COUNTER>23456</ITEM_COUNTER>
                            <ITEM_PREV_COUNTER>12345</ITEM_PREV_COUNTER>
                            <ITEM_PAYED_DEBT>123</ITEM_PAYED_DEBT>
                        </ITEM>
                    </ITEMS>
                </BILL>
            </BILLS>';

        /** @noinspection PhpUnhandledExceptionInspection */
        /** @var SystemPayment $notification */
        $notification = $this->server->handle($data);

        $this->assertEquals(
            new SystemPayment(
                new Entities\CompanyData(
                    'ПАТ «Березка»',
                    '1001'
                ),
                new Entities\BankData(
                    'АТ "Банк "Фінанси та Кредит"',
                    '300131',
                    '29244020902980'
                ),
                new Entities\BillData(
                    14561,
                    '3892/1',
                    Carbon::parse('2010-02-01'),
                    '0110'
                ),
                Carbon::parse('2010-02-15'),
                120.35,
                0,
                0,
                '739280',
                new Collections\Payers([
                    new Entities\PayerData('08967563', ['ATTRIBUTE1' => '12082010'])
                ]),
                new Collections\Meters([
                    new Entities\MeterData(
                        'testType',
                        '23456',
                        '12345',
                        10,
                        123,
                        120.56
                    )
                ])
            ),
            $notification
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?>
            <BILLS>
                <BILL>
                    <PAYEE>
                        <NAME>ПАТ «Березка»</NAME> 
                        <CODE>1001</CODE> 
                    </PAYEE>
                    <BANK>
                        <NAME>АТ "Банк "Фінанси та Кредит"</NAME> 
                        <CODE>300131</CODE> 
                        <ACCOUNT>29244020902980</ACCOUNT> 
                    </BANK>
                    <BILL_ID>14561</BILL_ID> 
                    <BILL_NUMBER>3892/1</BILL_NUMBER> 
                    <BILL_DATE>2010-02-01</BILL_DATE> 
                    <BILL_PERIOD>0110</BILL_PERIOD> 
                    <PAY_DATE>2010-02-15</PAY_DATE> 
                    <PAYED_AMOUNT>120.35</PAYED_AMOUNT> 
                    <PAYED_COMMISSION>0</PAYED_COMMISSION> 
                    <PAYED_DEBT>0</PAYED_DEBT> 
                    <AUTH_CODE>739280</AUTH_CODE> 
                    <PAYER>
                        <CONTRACT_NUMBER>08967563</CONTRACT_NUMBER>
                        <ATTRIBUTE1>12082010</ATTRIBUTE1>
                    </PAYER>
                </BILL>
            </BILLS>';

        /** @noinspection PhpUnhandledExceptionInspection */
        /** @var SystemPayment $notification */
        $notification = $this->server->handle($data);

        $this->assertEquals(
            new SystemPayment(
                new Entities\CompanyData(
                    'ПАТ «Березка»',
                    '1001'
                ),
                new Entities\BankData(
                    'АТ "Банк "Фінанси та Кредит"',
                    '300131',
                    '29244020902980'
                ),
                new Entities\BillData(
                    14561,
                    '3892/1',
                    Carbon::parse('2010-02-01'),
                    '0110'
                ),
                Carbon::parse('2010-02-15'),
                120.35,
                0,
                0,
                '739280',
                new Collections\Payers([
                    new Entities\PayerData('08967563', ['ATTRIBUTE1' => '12082010'])
                ]),
                new Collections\Meters()
            ),
            $notification
        );
    }

    /**
     * @expectedException \Wearesho\Bobra\Portmone\Notification\InvalidDataException
     * @expectedExceptionMessage Data contain invalid type
     */
    public function testInvalidDataHandle(): void
    {
        $data = '<?xml version="1.0" encoding="UTF-8"?><TEST></TEST>';
        $this->server->handle($data);
    }

    /**
     * @expectedException \Wearesho\Bobra\Portmone\Notification\InvalidDataException
     * @expectedExceptionMessage simplexml_load_string(): Entity: line 1: parser error : Start tag expected, '<' not
     *                           found Data contain invalid xml
     */
    public function testInvalidXmlHandle(): void
    {
        $data = 'testInvalidXml';
        $this->server->handle($data);
    }
}