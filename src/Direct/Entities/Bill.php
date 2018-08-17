<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

use Carbon\Carbon;

use Wearesho\Bobra\Portmone\Direct\Collections\Meters;

/**
 * Class Bill
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
abstract class Bill implements \JsonSerializable
{
    /** @var PayerData */
    protected $payer;

    /** @var string */
    protected $number;

    /** @var \DateTimeInterface */
    protected $billDate;

    /** @var float */
    protected $amount;

    /** @var float */
    protected $debt;

    /** @var Meters|null */
    protected $meters;

    public function __construct(
        PayerData $payer,
        string $number,
        \DateTimeInterface $billDate,
        float $amount,
        float $debt,
        Meters $meters = null
    ) {
        $this->number = $number;
        $this->billDate = $billDate;
        $this->amount = $amount;
        $this->debt = $debt;
        $this->meters = $meters;
    }

    public function jsonSerialize(): array
    {
        $json = [
            'payer' => $this->payer->jsonSerialize(),
            'number' => $this->number,
            'billDate' => Carbon::parse($this->billDate)->toDateString(),
            'amount' => $this->amount,
            'debt' => $this->debt
        ];

        if ($this->meters) {
            $json['meters'] = array_map(function (MeterData $meter) {
                return $meter->jsonSerialize();
            }, $this->meters->jsonSerialize());
        }

        return $json;
    }

    public function getPayer(): PayerData
    {
        return $this->payer;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getBillDate(): \DateTimeInterface
    {
        return $this->billDate;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getDebt(): float
    {
        return $this->debt;
    }

    public function getMeters(): ?Meters
    {
        return $this->meters;
    }
}
