<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct;

use Carbon\Carbon;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Config;
use Wearesho\Bobra\Portmone\Direct;

/**
 * Class ServerTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct
 * @coversDefaultClass \Wearesho\Bobra\Portmone\Direct\Server
 * @internal
 */
class ServerTest extends TestCase
{
    protected const KEY = 'testKey';
    protected const SECRET = 'testSecret';
    protected const PAYEE = 'testPayee';

    /** @var Direct\Server */
    protected $server;

    protected function setUp(): void
    {
        $this->server = new Direct\Server(new Config(
            static::KEY,
            static::SECRET,
            static::PAYEE
        ));
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
        /** @var Direct\InternalRequest $notification */
        $notification = $this->server->handle($data);

        $this->assertInstanceOf(Direct\InternalRequest::class, $notification);
        $this->assertEquals('1001', $notification->getPayee());
        $this->assertEquals(
            new Direct\Collections\Payers([
                new Direct\Entities\Payer(
                    '08967563',
                    [
                        'ATTRIBUTE1' => '12082010',
                    ]
                ),
                new Direct\Entities\Payer(
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
                </BILL>
            </BILLS>';

        /** @noinspection PhpUnhandledExceptionInspection */
        /** @var Direct\InternalPaymentNotification $notification */
        $notification = $this->server->handle($data);

        $this->assertEquals(
            new Direct\InternalPaymentNotification(
                new Direct\Entities\InternalBill(
                    14561,
                    new Direct\Entities\Company(
                        'ПАТ «Березка»',
                        '1001'
                    ),
                    new Direct\Entities\Bank(
                        'АТ "Банк "Фінанси та Кредит"',
                        '300131',
                        '29244020902980'
                    ),
                    '0110',
                    Carbon::parse('2010-02-15'),
                    0,
                    '739280',
                    new Direct\Entities\Payer('08967563', ['ATTRIBUTE1' => '12082010']),
                    '3892/1',
                    Carbon::parse('2010-02-01'),
                    120.35,
                    0
                )
            ),
            $notification
        );
    }

    public function testBankPaymentHandle(): void
    {
        $data = '<?xml version="1.0" encoding="UTF-8"?>
            <PAY_ORDERS>
                <PAY_ORDER>
                    <PAY_ORDER_ID>26792</PAY_ORDER_ID> 
                    <PAY_ORDER_DATE>2010-02-16</PAY_ORDER_DATE> 
                    <PAY_ORDER_NUMBER>120985735</PAY_ORDER_NUMBER>
                    <PAY_ORDER_AMOUNT>138.85</PAY_ORDER_AMOUNT> 
                    <PAYEE>
                        <NAME>ПАТ «Березка»</NAME> 
                        <CODE>1001</CODE> 
                    </PAYEE>
                    <BANK>
                        <NAME>АТ "Банк "Фінанси та Кредит"</NAME> 
                        <CODE>300131</CODE> 
                        <ACCOUNT>29244020902980</ACCOUNT> 
                    </BANK>
                    <BILLS>
                        <BILL>
                            <BILL_ID>14561</BILL_ID> 
                            <BILL_NUMBER>3892/1</BILL_NUMBER> 
                            <BILL_DATE>2010-02-01</BILL_DATE> 
                            <BILL_PERIOD>0110</BILL_PERIOD> 
                            <PAY_DATE>2010-02-15</PAY_DATE> 
                            <PAYED_AMOUNT>120.35</PAYED_AMOUNT> 
                            <PAYED_COMMISSION>5.00</PAYED_COMMISSION> 
                            <PAYED_DEBT>0</PAYED_DEBT> 
                            <AUTH_CODE>739280</AUTH_CODE> 
                            <PAYER>
                                <CONTRACT_NUMBER>08967563</CONTRACT_NUMBER>
                                <ATTRIBUTE1>12082010</ATTRIBUTE1>
                            </PAYER>
                        </BILL>
                        <BILL>
                            <BILL_ID>14569</BILL_ID> 
                            <BILL_NUMBER>3892/2</BILL_NUMBER> 
                            <BILL_DATE>2010-02-01</BILL_DATE> 
                            <BILL_PERIOD>0110</BILL_PERIOD> 
                            <PAY_DATE>2010-02-15 </PAY_DATE> 
                            <PAYED_AMOUNT>20.50</PAYED_AMOUNT> 
                            <PAYED_COMMISSION>1.00</PAYED_COMMISSION> 
                            <PAYED_DEBT>0</PAYED_DEBT> 
                            <AUTH_CODE>360157</AUTH_CODE> 
                            <PAYER>
                                <CONTRACT_NUMBER>08967568</CONTRACT_NUMBER>
                                <ATTRIBUTE1>12082011</ATTRIBUTE1>
                            </PAYER>
                        </BILL>
                    </BILLS>
                </PAY_ORDER>
            </PAY_ORDERS>';

        /** @noinspection PhpUnhandledExceptionInspection */
        /** @var Direct\BankPayment $notification */
        $notification = $this->server->handle($data);

        $this->assertEquals(
            new Direct\BankPayment(
                new Direct\Entities\PayOrder(
                    26792,
                    Carbon::parse('2010-02-16'),
                    '120985735',
                    138.85
                ),
                new Direct\Entities\Company(
                    'ПАТ «Березка»',
                    '1001'
                ),
                new Direct\Entities\Bank(
                    'АТ "Банк "Фінанси та Кредит"',
                    '300131',
                    '29244020902980'
                ),
                new Direct\Collections\OrderBills([
                    new Direct\Entities\OrderBill(
                        14561,
                        '0110',
                        Carbon::parse('2010-02-15'),
                        5.00,
                        '739280',
                        new Direct\Entities\Payer(
                            '08967563',
                            ['ATTRIBUTE1' => '12082010',]
                        ),
                        '3892/1',
                        Carbon::parse('2010-02-01'),
                        120.35,
                        0
                    ),
                    new Direct\Entities\OrderBill(
                        14569,
                        '0110',
                        Carbon::parse('2010-02-15'),
                        1.00,
                        '360157',
                        new Direct\Entities\Payer(
                            '08967568',
                            ['ATTRIBUTE1' => '12082011',]
                        ),
                        '3892/2',
                        Carbon::parse('2010-02-01'),
                        20.50,
                        0
                    )
                ])
            ),
            $notification
        );
    }

    public function testFormPayersResponse(): void
    {
        $payerResponse = new Direct\PayersResponse(
            new Direct\Collections\IdentifiedPayers(
                '0110',
                [
                    new Direct\Entities\IdentifiedPayer(
                        new Direct\Entities\Payer('192837465', ['918273645']),
                        '123456',
                        Carbon::parse('2018-03-12'),
                        123.45,
                        234.56,
                        'Comment'
                    ),
                ]
            ),
            new Direct\Collections\RejectedPayers([
                new Direct\Entities\RejectPayer(
                    new Direct\Error(Direct\Error::PAYER_NOT_FOUNT, 'Error'),
                    '321654987',
                    [
                        '234567890',
                        '321654987',
                        '132465978',
                        '890567234'
                    ]
                )
            ])
        );
        $responseBody = $this->server->formResponse($payerResponse);

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8"?>
            <RESPONSE>
                <BILLS>
                    <PAYEE>testPayee</PAYEE>
                    <BILL_PERIOD>0110</BILL_PERIOD>
                    <BILL>
                        <PAYER>
                            <CONTRACT_NUMBER>192837465</CONTRACT_NUMBER>
                            <ATTRIBUTE1>918273645</ATTRIBUTE1>
                        </PAYER>
                        <BILL_DATE>2018-03-12</BILL_DATE>
                        <BILL_NUMBER>123456</BILL_NUMBER>
                        <AMOUNT>123.45</AMOUNT>
                        <DEBT>234.56</DEBT>
                        <REMARK>Comment</REMARK>
                    </BILL>
                </BILLS>
                <REJECTS>
                    <PAYEE>testPayee</PAYEE>
                    <REJECT>
                        <PAYER>
                            <CONTRACT_NUMBER>321654987</CONTRACT_NUMBER>
                            <ATTRIBUTE1>234567890</ATTRIBUTE1>
                            <ATTRIBUTE2>321654987</ATTRIBUTE2>
                            <ATTRIBUTE3>132465978</ATTRIBUTE3>
                            <ATTRIBUTE4>890567234</ATTRIBUTE4>
                        </PAYER>
                        <ERROR_CODE>1</ERROR_CODE>
                        <ERROR_MESSAGE>Error</ERROR_MESSAGE>
                    </REJECT>
                </REJECTS>
            </RESPONSE>',
            $responseBody
        );
    }

    /**
     * @expectedException \Wearesho\Bobra\Portmone\Direct\InvalidDataException
     * @expectedExceptionMessage Data contain invalid type
     */
    public function testInvalidDataHandle(): void
    {
        $data = '<?xml version="1.0" encoding="UTF-8"?><TEST></TEST>';
        $this->server->handle($data);
    }

    /**
     * @expectedException \Wearesho\Bobra\Portmone\Direct\InvalidDataException
     * @expectedExceptionMessage simplexml_load_string(): Entity: line 1: parser error : Start tag expected, '<' not
     *                           found Data contain invalid xml
     */
    public function testInvalidXmlHandle(): void
    {
        $data = 'testInvalidXml';
        $this->server->handle($data);
    }
}
