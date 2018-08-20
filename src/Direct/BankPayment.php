<?php

namespace Wearesho\Bobra\Portmone\Direct;

use Wearesho\Bobra\Portmone\Direct\Entities;

/**
 * Class BankPayment
 * @package Wearesho\Bobra\Portmone\Direct
 */
class BankPayment extends Payment
{
    /** @var Entities\PayOrder */
    protected $payOrder;

    /** @var Collections\OrderBills */
    protected $bills;

    public function __construct(
        Entities\PayOrder $payOrder,
        Entities\Company $company,
        Entities\Bank $bank,
        Collections\OrderBills $bills
    ) {
        $this->payOrder = $payOrder;
        $this->bills = $bills;

        parent::__construct($company, $bank);
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'payOrder' => $this->payOrder->jsonSerialize(),
            'bills' => array_map(function (Entities\OrderBill $bill) {
                return $bill->jsonSerialize();
            }, $this->bills->jsonSerialize()),
        ]);
    }

    public function getPayOrder(): Entities\PayOrder
    {
        return $this->payOrder;
    }

    public function getBills(): Collections\OrderBills
    {
        return $this->bills;
    }
}
