<?php

namespace Wearesho\Bobra\Portmone\Notification;

/**
 * Class SystemPayment
 * @package Wearesho\Bobra\Portmone\Notification
 */
class SystemPayment extends Payment
{
    /** @var Entities\BillData */
    protected $bill;

    public function __construct(
        Entities\CompanyData $company,
        Entities\BankData $bank,
        Entities\BillData $bill
    ) {
        $this->bill = $bill;

        parent::__construct($company, $bank);
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'bill' => $this->bill->jsonSerialize(),
        ]);
    }

    public function getBill(): Entities\BillData
    {
        return $this->bill;
    }
}
