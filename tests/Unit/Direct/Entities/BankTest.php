<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Entities;

/**
 * Class BankDataTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities
 * @coversDefaultClass \Wearesho\Bobra\Portmone\Direct\Entities\Bank
 * @internal
 */
class BankTest extends TestCase
{
    protected const NAME = 'testName';
    protected const CODE = 'testCode';
    protected const ACCOUNT = 'testAccount';

    /** @var Entities\Bank */
    protected $fakeBank;

    protected function setUp(): void
    {
        $this->fakeBank = new Entities\Bank(static::NAME, static::CODE, static::ACCOUNT);
    }

    public function testGetName(): void
    {
        $this->assertEquals(
            static::NAME,
            $this->fakeBank->getName()
        );
    }

    public function testGetCode(): void
    {
        $this->assertEquals(
            static::CODE,
            $this->fakeBank->getCode()
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
            $this->fakeBank->jsonSerialize()
        );
    }

    public function testGetAccount(): void
    {
        $this->assertEquals(
            static::ACCOUNT,
            $this->fakeBank->getAccount()
        );
    }
}
