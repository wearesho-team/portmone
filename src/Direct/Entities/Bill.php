<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

use Carbon\Carbon;

/**
 * Class Bill
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
abstract class Bill implements \JsonSerializable
{
    /** @var Payer */
    protected $payer;

    /** @var string */
    protected $number;

    /** @var \DateTimeInterface */
    protected $setDate;

    /** @var float */
    protected $amount;

    /** @var float */
    protected $debt;

    public function __construct(
        Payer $payer,
        string $billNumber,
        \DateTimeInterface $billDate,
        float $amount,
        float $debt
    ) {
        $this->payer = $payer;
        $this->number = $billNumber;
        $this->setDate = $billDate;
        $this->amount = $amount;
        $this->debt = $debt;
    }

    public function jsonSerialize(): array
    {
        return [
            'payer' => $this->payer->jsonSerialize(),
            'number' => $this->number,
            'billDate' => Carbon::parse($this->setDate)->toDateString(),
            'amount' => $this->amount,
            'debt' => $this->debt
        ];
    }

    public function getPayer(): Payer
    {
        return $this->payer;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getSetDate(): \DateTimeInterface
    {
        return $this->setDate;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getDebt(): float
    {
        return $this->debt;
    }
}
