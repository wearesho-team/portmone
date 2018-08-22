<?php

namespace Wearesho\Bobra\Portmone\Direct;

use Wearesho\Bobra\Payments\PaymentInterface;
use Wearesho\Bobra\Portmone\NotificationInterface;

/**
 * Class InternalBillsNotification
 * @package Wearesho\Bobra\Portmone\Direct
 */
class InternalPaymentNotification implements PaymentInterface, NotificationInterface
{
    /** @var Entities\InternalBill */
    protected $bill;

    public function __construct(Entities\InternalBill $bill)
    {
        $this->bill = $bill;
    }

    public function jsonSerialize(): array
    {
        return [
            'bill' => $this->bill->jsonSerialize()
        ];
    }

    public function getPayee(): string
    {
        return $this->bill->getCompany()->getCode();
    }

    public function getId(): int
    {
        return $this->bill->getId();
    }

    public function getBill(): Entities\InternalBill
    {
        return $this->bill;
    }
}
