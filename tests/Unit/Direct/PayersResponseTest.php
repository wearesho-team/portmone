<?php

namespace Wearesho\Bobra\Portmone\Tests\Unit\Direct;

use Carbon\Carbon;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Portmone\Direct\Collections;
use Wearesho\Bobra\Portmone\Direct\Entities;
use Wearesho\Bobra\Portmone\Direct\Error;
use Wearesho\Bobra\Portmone\Direct\PayersResponse;

/**
 * Class PayersResponseTest
 * @package Wearesho\Bobra\Portmone\Tests\Unit\Direct
 * @coversDefaultClass PayersResponse
 * @internal
 */
class PayersResponseTest extends TestCase
{
    protected const PERIOD = '0110';
    protected const ERROR_CODE = 2;
    protected const ERROR_MESSAGE = 'error';
    protected const IDENTIFIED_CONTRACT_NUMBER = '321654987';
    protected const NON_IDENTIFIED_CONTRACT_NUMBER = '123456789';
    protected const BILL_NUMBER = '123098';
    protected const BILL_DATE = '2018-03-12';
    protected const AMOUNT = 123.45;
    protected const DEBT = 234.56;
    protected const REMARK = 'remark';

    /** @var PayersResponse */
    protected $fakePayersResponse;

    protected function setUp(): void
    {
        $this->fakePayersResponse = new PayersResponse(
            new Collections\IdentifiedPayers(
                static::PERIOD,
                [
                    new Entities\IdentifiedPayer(
                        new Entities\Payer(static::IDENTIFIED_CONTRACT_NUMBER),
                        static::BILL_NUMBER,
                        Carbon::parse(static::BILL_DATE),
                        static::AMOUNT,
                        static::DEBT,
                        static::REMARK
                    ),
                ]
            ),
            new Collections\RejectedPayers([
                new Entities\RejectPayer(
                    new Error(static::ERROR_CODE, static::ERROR_MESSAGE),
                    static::NON_IDENTIFIED_CONTRACT_NUMBER
                )
            ])
        );
    }

    public function testGetRejectedPayers(): void
    {
        $this->assertEquals(
            new Collections\RejectedPayers([
                new Entities\RejectPayer(
                    new Error(static::ERROR_CODE, static::ERROR_MESSAGE),
                    static::NON_IDENTIFIED_CONTRACT_NUMBER
                )
            ]),
            $this->fakePayersResponse->getRejectedPayers()
        );
    }

    public function testGetIdentifiedPayers(): void
    {
        $this->assertEquals(
            new Collections\IdentifiedPayers(
                static::PERIOD,
                [
                    new Entities\IdentifiedPayer(
                        new Entities\Payer(static::IDENTIFIED_CONTRACT_NUMBER),
                        static::BILL_NUMBER,
                        Carbon::parse(static::BILL_DATE),
                        static::AMOUNT,
                        static::DEBT,
                        static::REMARK
                    ),
                ]
            ),
            $this->fakePayersResponse->getIdentifiedPayers()
        );
    }
}
