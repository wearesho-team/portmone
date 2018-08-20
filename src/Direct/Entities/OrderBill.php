<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

use Carbon\Carbon;
use Wearesho\Bobra\Payments;

/**
 * Class OrderBill
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
class OrderBill extends Bill implements Payments\PaymentInterface
{
    use Payments\PaymentTrait;

    /**
     * Format: md
     *
     * @var string
     */
    protected $period;

    /** @var \DateTimeInterface */
    protected $payDate;

    /** @var float */
    protected $commission;

    /** @var string */
    protected $authCode;

    public function __construct(
        int $id,
        string $period,
        \DateTimeInterface $payDate,
        float $commission,
        string $authCode,
        Payer $payer,
        string $number,
        \DateTimeInterface $setDate,
        float $amount,
        float $debt
    ) {
        $this->id = $id;
        $this->period = $period;
        $this->payDate = $payDate;
        $this->commission = $commission;
        $this->authCode = $authCode;

        parent::__construct($payer, $number, $setDate, $amount, $debt);
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'id' => $this->id,
            'period' => $this->period,
            'payDate' => Carbon::instance($this->payDate)->toDateString(),
            'commission' => $this->commission,
            'authCode' => $this->authCode,
        ]);
    }

    public function getPeriod(): string
    {
        return $this->period;
    }

    public function getPayDate(): \DateTimeInterface
    {
        return $this->payDate;
    }

    public function getCommission(): float
    {
        return $this->commission;
    }

    public function getAuthCode(): string
    {
        return $this->authCode;
    }
}
