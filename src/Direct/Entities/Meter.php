<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

/**
 * Class Meter
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
class Meter implements \JsonSerializable
{
    /** @var string */
    protected $type;

    /** @var float */
    protected $amount;

    /** @var float */
    protected $subsidy;

    /** @var string */
    protected $currentCounter;

    /** @var string */
    protected $previousCounter;

    /** @var float */
    protected $debt;

    public function __construct(
        string $type,
        string $currentCounter,
        string $previousCounter,
        float $subsidy,
        float $debt,
        float $amount
    ) {
        $this->type = $type;
        $this->currentCounter = $currentCounter;
        $this->previousCounter = $previousCounter;
        $this->subsidy = $subsidy;
        $this->debt = $debt;
        $this->amount = $amount;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'counter' => [
                'current' => $this->currentCounter,
                'previous' => $this->previousCounter,
            ],
            'subsidy' => $this->subsidy,
            'debt' => $this->debt,
            'amount' => $this->amount,
        ];
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCurrentCounter(): string
    {
        return $this->currentCounter;
    }

    public function getPreviousCounter(): string
    {
        return $this->previousCounter;
    }

    public function getSubsidy(): float
    {
        return $this->subsidy;
    }

    public function getDebt(): float
    {
        return $this->debt;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
