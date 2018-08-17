<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Entities;

/**
 * Class PayerDataTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities
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

    /** @var Entities\PayerData */
    protected $payerData;

    protected function setUp(): void
    {
        $this->payerData = new Entities\PayerData(
            static::CONTRACT_NUMBER,
            static::ATTRIBUTES
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
                'attributes' => static::ATTRIBUTES
            ],
            $this->payerData->jsonSerialize()
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
