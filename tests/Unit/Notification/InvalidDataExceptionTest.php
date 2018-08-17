<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Notification;

use Wearesho\Bobra\Portmone\Direct\InvalidDataException;
use PHPUnit\Framework\TestCase;

/**
 * Class InvalidDataExceptionTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct
 * @internal
 */
class InvalidDataExceptionTest extends TestCase
{
    protected const DATA = 'testData';

    /** @var InvalidDataException */
    protected $exception;

    protected function setUp(): void
    {
        $this->exception = new InvalidDataException(static::DATA);
    }

    public function testGetData(): void
    {
        $this->assertEquals(
            static::DATA,
            $this->exception->getData()
        );
    }
}
