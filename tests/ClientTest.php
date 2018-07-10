<?php

namespace Wearesho\Bobra\Portmone\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments\HasLanguage;
use Wearesho\Bobra\Payments\Transaction;
use Wearesho\Bobra\Payments\UrlPair;
use Wearesho\Bobra\Portmone\Client;
use Wearesho\Bobra\Portmone\Config;
use Wearesho\Bobra\Portmone\Language;
use Wearesho\Bobra\Portmone\Payment;

/**
 * Class ClientTest
 * @package Wearesho\Bobra\Portmone\Tests
 * @coversDefaultClass \Wearesho\Bobra\Portmone\Client
 * @internal
 */
class ClientTest extends TestCase
{
    public function testCreatePayment(): void
    {
        $config = new Config('testKey', 'testSecret', 'testPayee', Language::EN, 'https://test.config.url/');

        $client = new Client($config);

        $payment = $client->createPayment(
            new UrlPair('https://good.url/', 'https://bad.url/'),
            new Transaction(
                1,
                10,
                'type',
                'description'
            )
        );

        $secondPayment = new Payment(
            'testPayee',
            1,
            1000,
            new UrlPair('https://good.url/', 'https://bad.url/'),
            Language::EN,
            'https://test.config.url/',
            'description'
        );

        $this->assertEquals($secondPayment, $payment);
    }

    public function testHasLanguage(): void
    {

        $config = new Config('testKey', 'testSecret', 'testPayee', Language::EN, 'https://test.config.url/');

        $client = new Client($config);

        $payment = $client->createPayment(
            new UrlPair('https://good.url/', 'https://bad.url/'),
            new class(1, 10, 'type', 'description')
                extends Transaction
                implements HasLanguage
            {
                public function getLanguage(): string
                {
                    return Language::UK;
                }
            }
        );

        $this->assertEquals(Language::UK, $payment->jsonSerialize()['data']['lang']);
    }
}
