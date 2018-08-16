<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities;

use Wearesho\Bobra\Portmone\Notification\Entities\CompanyData;

use PHPUnit\Framework\TestCase;

/**
 * Class CompanyDataTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities
 * @internal
 */
class CompanyDataTest extends TestCase
{
    protected const CODE = 'testCode';
    protected const NAME = 'testName';

    /** @var CompanyData */
    protected $companyData;

    protected function setUp(): void
    {
        $this->companyData = new CompanyData(static::NAME, static::CODE);
    }

    public function testGetCode(): void
    {
        $this->assertEquals(
            static::CODE,
            $this->companyData->getCode()
        );
    }

    public function testGetName(): void
    {
        $this->assertEquals(
            static::NAME,
            $this->companyData->getName()
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'name' => static::NAME,
                'code' => static::CODE
            ],
            $this->companyData->jsonSerialize()
        );
    }
}
