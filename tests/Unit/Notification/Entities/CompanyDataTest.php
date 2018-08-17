<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification\Entities;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Entities\Company;

/**
 * Class CompanyDataTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities
 * @internal
 */
class CompanyDataTest extends TestCase
{
    protected const CODE = 'testCode';
    protected const NAME = 'testName';

    /** @var Company */
    protected $companyData;

    protected function setUp(): void
    {
        $this->companyData = new Company(static::NAME, static::CODE);
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
