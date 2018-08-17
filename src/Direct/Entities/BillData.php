<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

use Carbon\Carbon;

use Wearesho\Bobra\Portmone\Direct\Collections;

/**
 * Class Bill
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
class BillData implements \JsonSerializable
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $number;

    /** @var \DateTimeInterface */
    protected $billDate;

    /** @var string */
    protected $period;

    /** @var \DateTimeInterface */
    protected $payDate;

    /** @var float */
    protected $payedAmount;

    /** @var float */
    protected $payedCommission;

    /** @var float */
    protected $payedDebt;

    /** @var string */
    protected $authCode;

    /** @var PayerData */
    protected $payer;

    /** @var Collections\Meters */
    protected $meters;

    public function __construct(
        int $id,
        string $number,
        \DateTimeInterface $billDate,
        \DateTimeInterface $payDate,
        string $period,
        float $amount,
        float $commission,
        float $debt,
        string $authCode,
        PayerData $payer,
        Collections\Meters $meters
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->billDate = $billDate;
        $this->payDate = $payDate;
        $this->period = $period;
        $this->payedAmount = $amount;
        $this->payedCommission = $commission;
        $this->payedDebt = $debt;
        $this->authCode = $authCode;
        $this->payer = $payer;
        $this->meters = $meters;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'billDate' => Carbon::instance($this->billDate)->toDateString(),
            'payDate' => Carbon::instance($this->payDate)->toDateString(),
            'period' => $this->period,
            'amount' => $this->payedAmount,
            'commission' => $this->payedCommission,
            'payedDebt' => $this->payedDebt,
            'authCode' => $this->authCode,
            'payer' => $this->payer->jsonSerialize(),
            'meters' => array_map(function (MeterData $meter) {
                return $meter->jsonSerialize();
            }, $this->meters->jsonSerialize()),
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getBillDate(): \DateTimeInterface
    {
        return $this->billDate;
    }

    public function getPeriod(): string
    {
        return $this->period;
    }

    public function getPayDate(): \DateTimeInterface
    {
        return $this->payDate;
    }

    public function getPayedAmount(): float
    {
        return $this->payedAmount;
    }

    public function getPayedCommission(): float
    {
        return $this->payedCommission;
    }

    public function getPayedDebt(): float
    {
        return $this->payedDebt;
    }

    public function getAuthCode(): string
    {
        return $this->authCode;
    }

    public function getPayer(): PayerData
    {
        return $this->payer;
    }

    public function getMeters(): Collections\Meters
    {
        return $this->meters;
    }
}
