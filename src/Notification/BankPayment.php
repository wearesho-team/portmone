<?php

namespace Wearesho\Bobra\Portmone\Notification;

use Wearesho\Bobra\Portmone\Notification\Entities\BillData;
use Wearesho\Bobra\Portmone\Notification\Entities\PayOrderData;
use Wearesho\Bobra\Payments;

/**
 * Class BankPayment
 * @package Wearesho\Bobra\Portmone\Notification
 */
class BankPayment extends Payment implements Payments\PaymentInterface
{
    /** @var PayOrderData */
    protected $payOrder;

    /** @var Collections\Bills */
    protected $bills;

    public function __construct(
        PayOrderData $payOrder,
        Entities\CompanyData $company,
        Entities\BankData $bank,
        Collections\Bills $bills
    ) {
        $this->payOrder = $payOrder;
        $this->bills = $bills;

        parent::__construct($company, $bank);
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'payOrder' => $this->payOrder->jsonSerialize(),
            'bills' => array_map(function (BillData $bill) {
                return $bill->jsonSerialize();
            }, $this->bills->jsonSerialize()),
        ]);
    }

    public function getId(): int
    {
        return $this->payOrder->getId();
    }
}
