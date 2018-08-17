<?php

namespace Wearesho\Bobra\Portmone\Direct;

use Wearesho\Bobra\Portmone\Direct\Collections\InternalBills;

/**
 * Class InternalBillsNotification
 * @package Wearesho\Bobra\Portmone\Direct
 */
class InternalPaymentNotification extends Payment
{
    /** @var InternalBills */
    protected $bills;

    public function __construct(
        Entities\CompanyData $company,
        Entities\BankData $bank,
        InternalBills $bills
    ) {
        $this->bills = $bills;

        parent::__construct($company, $bank);
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'bills' => $this->bills->jsonSerialize(),
        ]);
    }

    public function getBills(): InternalBills
    {
        return $this->bills;
    }
}
