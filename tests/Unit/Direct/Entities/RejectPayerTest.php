<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Entities\RejectPayer;
use Wearesho\Bobra\Portmone\Direct\Message;

/**
 * Class RejectPayerTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct\Entities
 * @coversDefaultClass RejectPayer
 * @internal
 */
class RejectPayerTest extends TestCase
{
    protected const ERROR_CODE = 1;
    protected const ERROR_MESSAGE = 'message';
    protected const CONTRACT_NUMBER = '123456789';

    /** @var RejectPayer */
    protected $fakeRejectPayer;

    protected function setUp(): void
    {
        $this->fakeRejectPayer = new RejectPayer(
            new Message(static::ERROR_CODE, static::ERROR_MESSAGE),
            static::CONTRACT_NUMBER
        );
    }

    public function testGetError(): void
    {
        $this->assertEquals(
            new Message(static::ERROR_CODE, static::ERROR_MESSAGE),
            $this->fakeRejectPayer->getError()
        );
    }
}
