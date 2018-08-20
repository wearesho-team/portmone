<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Error;

/**
 * Class ErrorTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct
 * @coversDefaultClass Error
 * @internal
 */
class ErrorTest extends TestCase
{
    protected const CODE = 1;
    protected const MESSAGE = 'message';
    protected const DOCUMENT_ID = '123456';

    /** @var Error */
    protected $fakeError;

    protected function setUp(): void
    {
        $this->fakeError = new Error(
            static::CODE,
            static::MESSAGE,
            static::DOCUMENT_ID
        );
    }

    public function testGetCode(): void
    {
        $this->assertEquals(
            static::CODE,
            $this->fakeError->getCode()
        );
    }

    public function testGetMessage(): void
    {
        $this->assertEquals(
            static::MESSAGE,
            $this->fakeError->getMessage()
        );
    }

    public function testGetDocumentId(): void
    {
        $this->assertEquals(
            static::DOCUMENT_ID,
            $this->fakeError->getDocumentId()
        );
    }
}
