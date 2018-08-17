<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

use Carbon\Carbon;

use Wearesho\Bobra\Payments\PaymentInterface;
use Wearesho\Bobra\Payments\PaymentTrait;
use Wearesho\Bobra\Portmone\Direct\Collections\Meters;

/**
 * Information of fast Payment in Portmone service
 *
 * Class InternalBill
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
class InternalBill extends Bill implements \JsonSerializable, PaymentInterface
{
    use PaymentTrait;

    /**
     * Format: md
     *
     * @var string
     */
    protected $period;

    /** @var \DateTimeInterface */
    protected $payDate;

    /** @var string */
    protected $authCode;

    public function __construct(
        PayerData $payer,
        string $period,
        \DateTimeInterface $payDate,
        string $number,
        \DateTimeInterface $billDate,
        float $amount,
        float $debt,
        string $authCode,
        Meters $meters = null
    ) {
        $this->period = $period;
        $this->payDate = $payDate;
        $this->authCode = $authCode;

        parent::__construct(
            $payer,
            $number,
            $billDate,
            $amount,
            $debt,
            $meters
        );
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'id' => $this->id,
            'period' => $this->period,
            'payDate' => Carbon::instance($this->payDate)->toDateString()
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
}
