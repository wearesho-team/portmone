<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

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
        float $payedCommission,
        string $authCode,
        Payer $payer,
        string $number,
        \DateTimeInterface $setDate,
        float $payedAmount,
        float $payedDebt
    ) {
        $this->company = $company;
        $this->bank = $bank;

        parent::__construct(
            $id,
            $period,
            $payDate,
            $payedCommission,
            $authCode,
            $payer,
            $number,
            $setDate,
            $payedAmount,
            $payedDebt
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
