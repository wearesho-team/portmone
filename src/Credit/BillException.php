<?php

namespace Wearesho\Bobra\Portmone\Credit;

use Wearesho\Bobra\Payments\Credit\Exception;
use Wearesho\Bobra\Payments\Credit\TransferInterface;

/**
 * Class BillException
 * @package Wearesho\Bobra\Portmone\Credit
 */
class BillException extends Exception
{
    /** @var string */
    protected $errorCode;

    public function __construct(
        TransferInterface $transfer,
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
