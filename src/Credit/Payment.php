<?php

namespace Wearesho\Bobra\Portmone\Credit;

use Wearesho\Bobra\Payments;

/**
 * Class Payment
 * @package Wearesho\Bobra\Portmone\Credit
 */
class Payment implements Payments\Credit\Response
{
    /** @var string */
    protected $billId;

    /** @var \DateTimeInterface */
    protected $payedDate;

    /** @var float */
    protected $payedAmount;

    /** @var string */
    protected $status;

    public function __construct(string $billId, \DateTimeInterface $payedDate, float $payedAmount, string $status)
    {
        $this->billId = $billId;
        $this->payedDate = $payedDate;
        $this->payedAmount = $payedAmount;
        $this->status = $status;
    }

    public function getBillId(): string
    {
        return $this->billId;
    }

    public function getPayedDate(): \DateTimeInterface
    {
        return $this->payedDate;
    }

    public function getPayedAmount(): float
    {
        return $this->payedAmount;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
