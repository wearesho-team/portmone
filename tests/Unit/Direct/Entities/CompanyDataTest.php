<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Entities\Company;

/**
 * Class CompanyDataTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities
 * @coversDefaultClass \Wearesho\Bobra\Portmone\Direct\Entities\Company
 * @internal
 */
class CompanyDataTest extends TestCase
{
    protected const CODE = 'testCode';
    protected const NAME = 'testName';

    /** @var Company */
    protected $fakeCompany;

    protected function setUp(): void
    {
        $this->fakeCompany = new Company(static::NAME, static::CODE);
    }

    public function testGetCode(): void
    {
        $this->assertEquals(
            static::CODE,
            $this->fakeCompany->getCode()
        );
    }

    public function testGetName(): void
    {
        $this->assertEquals(
            static::NAME,
            $this->fakeCompany->getName()
        );
    }

    public function testJsonSerialize(): void
    {
        $this->assertArraySubset(
            [
                'name' => static::NAME,
                'code' => static::CODE
            ],
            $this->fakeCompany->jsonSerialize()
        );
    }
}
