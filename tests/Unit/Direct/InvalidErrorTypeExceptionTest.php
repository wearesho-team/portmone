<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Error;
use Wearesho\Bobra\Portmone\Direct\InvalidErrorTypeException;

/**
 * Class InvalidErrorTypeExceptionTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct
 * @coversDefaultClass InvalidErrorTypeException
 * @internal
 */
class InvalidErrorTypeExceptionTest extends TestCase
{
    protected const INVALID_ERROR_TYPE = 10;
    protected const ERROR_CODE = 1;
    protected const ERROR_MESSAGE = 'message';

    /** @var InvalidErrorTypeException */
    protected $fakeException;

    protected function setUp(): void
    {
        $this->fakeException = new InvalidErrorTypeException(
            static::INVALID_ERROR_TYPE,
            new Error(static::ERROR_CODE, static::ERROR_MESSAGE)
        );
    }

    public function testGetErrorType(): void
    {
        $this->assertEquals(
            static::INVALID_ERROR_TYPE,
            $this->fakeException->getErrorType()
        );
    }

    public function testGetErrorContent(): void
    {
        $this->assertEquals(
            new Error(static::ERROR_CODE, static::ERROR_MESSAGE),
            $this->fakeException->getErrorContent()
        );
    }
}
