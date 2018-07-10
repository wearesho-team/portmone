<?php

namespace Wearesho\Bobra\Portmone\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Payments\UrlPair;
use Wearesho\Bobra\Portmone\{
    Language, Payment
};

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
        $payment = new Payment(
            "123",
            1,
            100,
            new UrlPair('https://test.com/'),
            Language::RU,
            'https://test.com',
            'test description',
            'test encoding'
        );

        $this->assertEquals(1, $payment->getId());

        $json = $payment->jsonSerialize();
        $this->assertEquals('https://test.com', $json['url']);

        $data = $json['data'];

        $this->assertEquals('123', $data['payee_id']);
        $this->assertEquals(1, $data['shop_order_number']);
        $this->assertEquals('1.00', $data['bill_amount']);
        $this->assertEquals('test description', $data['description']);
        $this->assertEquals('https://test.com/', $data['success_url']);
        $this->assertEquals('https://test.com/', $data['failure_url']);
        $this->assertEquals(Language::RU, $data['lang']);;
        $this->assertEquals('test encoding', $data['encoding']);
    }

    public function testEmptyDescription(): void
    {
        $payment = new Payment(
            "123",
            1,
            100,
            new UrlPair('https://test.com/'),
            Language::RU,
            'https://test.com'
        );

        $data = $payment->jsonSerialize();
        $this->assertArrayHasKey('description', $data['data']);
        $this->assertEquals('', $data['data']['description']);
    }

    public function testEmptyEncoding(): void
    {
        $payment = new Payment(
            "123",
            1,
            100,
            new UrlPair('https://test.com/'),
            Language::RU,
            'https://test.com',
            '',
            null
        );

        $data = $payment->jsonSerialize();
        $this->assertArrayNotHasKey('encoding', $data['data']);
    }
}
