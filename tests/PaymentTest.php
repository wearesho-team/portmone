<?php

namespace Wearesho\Bobra\Portmone\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments\UrlPair;
use Wearesho\Bobra\Portmone;

/**
 * Class PaymentTest
 * @package Wearesho\Bobra\Portmone\Tests
 * @coversDefaultClass \Wearesho\Bobra\Portmone\Payment
 * @internal
 */
class PaymentTest extends TestCase
{
    public function testFields(): void
    {
        $payment = new Portmone\Payment(
            "123",
            1,
            100,
            new UrlPair('https://test.com/'),
            Portmone\Language::RU,
            'https://test.com',
            [
                'attribute2' => 'test',
            ],
            'test description',
            'test encoding'
        );

        $this->assertEquals(1, $payment->getId());

        $json = $payment->jsonSerialize();
        $this->assertEquals([
            'url' => 'https://test.com',
            'data' => [
                'payee_id' => '123',
                'shop_order_number' => 1,
                'bill_amount' => '1.00',
                'description' => 'test description',
                'success_url' => 'https://test.com/',
                'failure_url' => 'https://test.com/',
                'lang' => 'ru',
                'encoding' => 'test encoding',
                'attribute2' => 'test',
            ],
        ], $json);
    }

    public function testEmptyDescription(): void
    {
        $payment = new Portmone\Payment(
            "123",
            1,
            100,
            new UrlPair('https://test.com/'),
            Portmone\Language::RU,
            'https://test.com'
        );

        $data = $payment->jsonSerialize();
        $this->assertArrayHasKey('description', $data['data']);
        $this->assertEquals('', $data['data']['description']);
    }

    public function testEmptyEncoding(): void
    {
        $payment = new Portmone\Payment(
            "123",
            1,
            100,
            new UrlPair('https://test.com/'),
            Portmone\Language::RU,
            'https://test.com',
            [],
            '',
            null
        );

        $data = $payment->jsonSerialize();
        $this->assertArrayNotHasKey('encoding', $data['data']);
    }
}
