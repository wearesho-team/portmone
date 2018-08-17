<?php

namespace Wearesho\Bobra\Portmone\Notification;

use Carbon\Carbon;

use Wearesho\Bobra\Payments\PaymentInterface;
use Wearesho\Bobra\Portmone\NotificationInterface;

/**
 * Class SystemPayment
 * @package Wearesho\Bobra\Portmone\Notification
 */
class SystemPayment implements PaymentInterface, NotificationInterface
{
    /** @var Entities\CompanyData */
    protected $company;

    /** @var Entities\BankData */
    protected $bank;

    /** @var Entities\BillData */
    protected $bill;

    /** @var \DateTimeInterface */
    protected $date;

    /** @var float */
    protected $amount;

    /** @var float */
    protected $commission;

    /** @var float */
    protected $debt;

    /** @var string */
    protected $authCode;

    /** @var Collections\Payers */
    protected $payers;

    /** @var Collections\Meters */
    protected $meters;

    public function __construct(
        Entities\CompanyData $company,
        Entities\BankData $bank,
        Entities\BillData $bill,
        \DateTimeInterface $date,
        float $amount,
        float $commission,
        float $debt,
        string $authCode,
        Collections\Payers $payers,
        Collections\Meters $meters
    ) {
        $this->company = $company;
        $this->bank = $bank;
        $this->bill = $bill;
        $this->date = $date;
        $this->amount = $amount;
        $this->commission = $commission;
        $this->debt = $debt;
        $this->authCode = $authCode;
        $this->payers = $payers;
        $this->meters = $meters;
    }

    public function jsonSerialize(): array
    {
        return [
            'company' => $this->company->jsonSerialize(),
            'bank' => $this->bank->jsonSerialize(),
            'bill' => $this->bill->jsonSerialize(),
            'date' => Carbon::instance($this->date)->toDateString(),
            'amount' => $this->amount,
            'commission' => $this->commission,
            'debt' => $this->debt,
            'authCode' => $this->authCode,
            'payers' => array_map(function (Entities\PayerData $payer) {
                return $payer->jsonSerialize();
            }, $this->payers->jsonSerialize()),
            'meters' => array_map(function (Entities\MeterData $meter) {
                return $meter->jsonSerialize();
            }, $this->meters->jsonSerialize())
        ];
    }

    public function getPayee(): string
    {
        return $this->company->getCode();
    }

    public function getId(): int
    {
        return $this->bill->getId();
    }

    public function getCompany(): Entities\CompanyData
    {
        return $this->company;
    }

    public function getBank(): Entities\BankData
    {
        return $this->bank;
    }

    public function getBill(): Entities\BillData
    {
        return $this->bill;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCommission(): float
    {
        return $this->commission;
    }

    public function getDebt(): float
    {
        return $this->debt;
    }

    public function getAuthCode(): string
    {
        return $this->authCode;
    }

    public function getMeters(): Collections\Meters
    {
        return $this->meters;
    }

    public function getPayers(): Collections\Payers
    {
        return $this->payers;
    }
}
