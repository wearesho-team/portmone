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
class InternalBill extends OrderBill implements \JsonSerializable
{
    /** @var Bank */
    protected $bank;

    /** @var Company */
    protected $company;

    public function __construct(
        int $id,
        Company $company,
        Bank $bank,
        string $period,
        \DateTimeInterface $payDate,
        float $commission,
        string $authCode,
        Payer $payer,
        string $number,
        \DateTimeInterface $billDate,
        float $amount,
        float $debt,
        Meters $meters = null
    ) {
        $this->company = $company;
        $this->bank = $bank;

        parent::__construct(
            $id,
            $period,
            $payDate,
            $commission,
            $authCode,
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
            'company' => $this->company->jsonSerialize(),
            'bank' => $this->bank->jsonSerialize(),
        ]);
    }

    public function getBank(): Bank
    {
        return $this->bank;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }
}
