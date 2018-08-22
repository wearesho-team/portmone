<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct;

use Wearesho\Bobra\Portmone\Direct\InvalidDataException;
use PHPUnit\Framework\TestCase;

/**
 * Class InvalidDataExceptionTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct
 * @coversDefaultClass \Wearesho\Bobra\Portmone\Direct\InvalidDataException
 * @internal
 */
class InvalidDataExceptionTest extends TestCase
{
    protected const DATA = 'testData';

    /** @var InvalidDataException */
    protected $fakeException;

    protected function setUp(): void
    {
        $this->fakeException = new InvalidDataException(static::DATA);
    }

    public function testGetData(): void
    {
        $this->assertEquals(
            static::DATA,
            $this->fakeException->getData()
        );
    }
}
