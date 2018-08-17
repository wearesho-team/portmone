<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Entities\Bank;

/**
 * Class BankDataTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities
 * @internal
 */
class BankDataTest extends TestCase
{
    protected const NAME = 'testName';
    protected const CODE = 'testCode';
    protected const ACCOUNT = 'testAccount';

    /** @var Bank */
    protected $bankData;

    protected function setUp(): void
    {
        $this->bankData = new Bank(static::NAME, static::CODE, static::ACCOUNT);
    }

    public function testGetName(): void
    {
        $this->assertEquals(
            static::NAME,
            $this->bankData->getName()
        );
    }

    public function testGetCode(): void
    {
        $this->assertEquals(
            static::CODE,
            $this->bankData->getCode()
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'name' => static::NAME,
                'code' => static::CODE,
                'account' => static::ACCOUNT,
            ],
            $this->bankData->jsonSerialize()
        );
    }

    public function testGetAccount(): void
    {
        $this->assertEquals(
            static::ACCOUNT,
            $this->bankData->getAccount()
        );
    }
}
