<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Credit;

use Carbon\Carbon;
use GuzzleHttp;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Payments\Credit\Transfer;
use Wearesho\Bobra\Portmone\Config;
use Wearesho\Bobra\Portmone\Credit;

/**
 * Class ClientTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Credit
 * @coversDefaultClass \Wearesho\Bobra\Portmone\Credit\Client
 * @internal
 */
class ClientTest extends TestCase
{
    protected const KEY = 'testKey';
    protected const SECRET = 'testSecret';
    protected const PAYEE = 'testPayee';

    /** @var Credit\Client */
    protected $fakeClient;

    /** @var Config */
    protected $fakeConfig;

    protected function setUp(): void
    {
        $this->fakeConfig = new Config(static::KEY, static::SECRET, static::PAYEE);
    }

    /**
     * @expectedException \Wearesho\Bobra\Portmone\Credit\BillException
     * @expectedExceptionMessage Invalid method name
     */
    public function testHandleErrorResponse(): void
    {
        $body = '<?xml version="1.0" encoding="utf-8"?>
            <rsp status="fail">
                <error code="p001">Invalid method name</error>
            </rsp>';
        $mock = new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(200, [], $body),
        ]);
        $stack = GuzzleHttp\HandlerStack::create($mock);
        $client = new GuzzleHttp\Client(['handler' => $stack,]);
        $this->fakeClient = new Credit\Client($this->fakeConfig, $client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->fakeClient->send(new Transfer(
            123456,
            1200.45,
            '1234123412341234'
        ));
    }

    /**
     * @expectedException \Wearesho\Bobra\Payments\Credit\Exception
     * @expectedExceptionMessage simplexml_load_string(): Entity: line 1: parser error : Start tag expected, '<' not
     *                           found
     */
    public function testHandleInvalidXml(): void
    {
        $body = 'invalid xml';
        $mock = new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(200, [], $body),
        ]);
        $stack = GuzzleHttp\HandlerStack::create($mock);
        $client = new GuzzleHttp\Client(['handler' => $stack,]);
        $this->fakeClient = new Credit\Client($this->fakeConfig, $client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->fakeClient->send(new Transfer(
            123456,
            1200.45,
            '1234123412341234'
        ));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Incorrect payee id returned from Portmone service
     */
    public function testHandleInvalidPayee(): void
    {
        $body = '<?xml version="1.0" encoding="utf-8"?>
            <rsp status="ok">
                <bill id="523">
                    <payee id="invalid"></payee>
                </bill>
            </rsp>';
        $mock = new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(200, [], $body),
        ]);
        $stack = GuzzleHttp\HandlerStack::create($mock);
        $client = new GuzzleHttp\Client(['handler' => $stack,]);
        $this->fakeClient = new Credit\Client($this->fakeConfig, $client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->fakeClient->send(new Transfer(
            123456,
            1200.45,
            '1234123412341234'
        ));
    }

    public function testHandleSuccessTransfer(): void
    {
        $createdBill = '<?xml version="1.0" encoding="utf-8"?>
            <rsp status="ok">
                <bill id="523">
                    <payee id="testPayee">name</payee>
                </bill>
            </rsp>';
        $payedBill = '<?xml version="1.0" encoding="utf-8"?>
            <rsp status="ok">
                <bill id="523">
                    <payee id="testPayee">name</payee>
                    <paidAmount>1200.45</paidAmount>
                    <payDate>12.03.1998 15:45:48</payDate>
                    <status>paid</status>
                </bill>
            </rsp>';
        $mock = new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(200, [], $createdBill),
            new GuzzleHttp\Psr7\Response(200, [], $payedBill),
        ]);
        $stack = GuzzleHttp\HandlerStack::create($mock);
        $client = new GuzzleHttp\Client(['handler' => $stack,]);
        $this->fakeClient = new Credit\Client($this->fakeConfig, $client);

        /** @noinspection PhpUnhandledExceptionInspection */
        /** @var Credit\Response $response */
        $response = $this->fakeClient->send(new Transfer(
            123456,
            1200.45,
            '1234123412341234'
        ));

        $this->assertEquals(
            523,
            $response->getBillId()
        );
        $this->assertEquals(
            1200.45,
            $response->getPayedAmount()
        );
        $this->assertEquals(
            '12.03.1998 15:45:48',
            Carbon::instance($response->getPayedDate())->format('d.m.Y H:i:s')
        );
        $this->assertEquals(
            'paid',
            $response->getStatus()
        );
    }

    /**
     * @expectedException \Wearesho\Bobra\Payments\Credit\Exception
     * @expectedExceptionMessage Invalid card number
     */
    public function testInvalidCardToken(): void
    {
        $this->fakeClient = new Credit\Client($this->fakeConfig, new GuzzleHttp\Client());
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->fakeClient->send(new Transfer(
            123456,
            1200.45,
            '123'
        ));
    }
}
