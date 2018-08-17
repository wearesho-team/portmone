<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification;

use Wearesho\Bobra\Portmone\Notification\Collections\Payers;
use Wearesho\Bobra\Portmone\Notification\Entities\PayerData;
use Wearesho\Bobra\Portmone\Notification\SystemRequest;

use PHPUnit\Framework\TestCase;

/**
 * Class SystemRequestTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Notification
 * @internal
 */
class SystemRequestTest extends TestCase
{
    protected const PAYEE = 'testPayee';
    protected const CONTRACT_NUMBER = 'testNumber';

    /** @var SystemRequest */
    protected $systemRequest;

    protected function setUp(): void
    {
        $this->systemRequest = new SystemRequest(
            static::PAYEE,
            new Payers([
                new PayerData(static::CONTRACT_NUMBER),
                new PayerData(static::CONTRACT_NUMBER)
            ])
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'payee' => static::PAYEE,
                'payers' => [
                    ['contractNumber' => static::CONTRACT_NUMBER,],
                    ['contractNumber' => static::CONTRACT_NUMBER,],
                ],
            ],
            $this->systemRequest->jsonSerialize()
        );
    }

    public function testGetPayee(): void
    {
        $this->assertEquals(
            static::PAYEE,
            $this->systemRequest->getPayee()
        );
    }

    public function testGetPayers(): void
    {
        $this->assertEquals(
            new Payers([
                new PayerData(static::CONTRACT_NUMBER),
                new PayerData(static::CONTRACT_NUMBER)
            ]),
            $this->systemRequest->getPayers()
        );
    }
}
