<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities;

use Wearesho\Bobra\Portmone\Notification\Entities\PayerData;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Portmone\Notification\Entities\PayerType;

/**
 * Class PayerDataTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities
 * @internal
 */
class PayerDataTest extends TestCase
{
    protected const ATTRIBUTES = [
        'ATTRIBUTE1' => '123456',
        'ATTRIBUTE2' => '321654',
        'ATTRIBUTE3' => '654321'
    ];
    protected const CONTRACT_NUMBER = '213546';

    /** @var PayerData */
    protected $payerData;

    protected function setUp(): void
    {
        $this->payerData = new PayerData(
            static::CONTRACT_NUMBER,
            static::ATTRIBUTES,
            PayerType::APPROVED()
        );
    }

    public function testGetAttributes(): void
    {
        $this->assertArraySubset(
            static::ATTRIBUTES,
            $this->payerData->getAttributes()
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'contractNumber' => static::CONTRACT_NUMBER,
                'attributes' => static::ATTRIBUTES,
                'type' => 'APPROVED'
            ],
            $this->payerData->jsonSerialize()
        );
    }

    public function testGetType(): void
    {
        $this->assertEquals(
            PayerType::APPROVED(),
            $this->payerData->getType()
        );
    }

    public function testGetContractNumber(): void
    {
        $this->assertEquals(
            static::CONTRACT_NUMBER,
            $this->payerData->getContractNumber()
        );
    }
}