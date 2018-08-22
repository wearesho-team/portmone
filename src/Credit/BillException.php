<?php

namespace Wearesho\Bobra\Portmone\Credit;

use Wearesho\Bobra\Payments;

/**
 * Class BillException
 * @package Wearesho\Bobra\Portmone\Credit
 */
class BillException extends Payments\Credit\Exception
{
    /** @var string */
    protected $errorCode;

    public function __construct(
        Payments\Credit\TransferInterface $transfer,
        string $errorCode,
        string $message,
        int $code = 0,
        \Throwable $previous = null
    ) {
        $this->errorCode = $errorCode;

        parent::__construct($transfer, $message, $code, $previous);
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
