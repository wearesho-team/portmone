<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification;

use Wearesho\Bobra\Portmone\Direct\Collections\Payers;
use Wearesho\Bobra\Portmone\Direct\Entities\Payer;
use Wearesho\Bobra\Portmone\Direct\InternalRequest;

use PHPUnit\Framework\TestCase;

/**
 * Class SystemRequestTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct
 * @internal
 */
class SystemRequestTest extends TestCase
{
    protected const PAYEE = 'testPayee';
    protected const CONTRACT_NUMBER = 'testNumber';

    /** @var InternalRequest */
    protected $systemRequest;

    protected function setUp(): void
    {
        $this->systemRequest = new InternalRequest(
            static::PAYEE,
            new Payers([
                new Payer(static::CONTRACT_NUMBER),
                new Payer(static::CONTRACT_NUMBER)
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
                new Payer(static::CONTRACT_NUMBER),
                new Payer(static::CONTRACT_NUMBER)
            ]),
            $this->systemRequest->getPayers()
        );
    }
}
