<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Credit;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Payments\Credit\Transfer;
use Wearesho\Bobra\Portmone\Credit\BillException;

/**
 * Class BillExceptionTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Credit
 * @coversDefaultClass BillException
 * @internal
 */
class BillExceptionTest extends TestCase
{
    /** @var BillException */
    protected $fakeBillException;

    protected function setUp(): void
    {
        $this->fakeBillException = new BillException(
            new Transfer(
                123456,
                1200.45,
                '1234123412341234'
            ),
            'p001',
            'Invalid method name'
        );
    }

    public function testGetTransfer(): void
    {
        $this->assertEquals(
            new Transfer(
                123456,
                1200.45,
                '1234123412341234'
            ),
            $this->fakeBillException->getTransfer()
        );
    }

    public function testGetError(): void
    {
        $this->assertEquals(
            'p001',
            $this->fakeBillException->getErrorCode()
        );
    }

    public function testGetMessage(): void
    {
        $this->assertEquals(
            'Invalid method name',
            $this->fakeBillException->getMessage()
        );
    }
}
