<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

/**
 * Class RegistryBill
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
class IdentifiedPayer extends Bill
{
    /** @var string|null */
    protected $remark;

    public function __construct(
        Payer $payer,
        string $billNumber,
        \DateTimeInterface $billDate,
        float $amount,
        float $debt,
        ?string $remark = null
    ) {
        $this->remark = $remark;

        parent::__construct($payer, $billNumber, $billDate, $amount, $debt);
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'remark' => $this->remark,
        ]);
    }

    public function getRemark(): ?string
    {
        return $this->remark;
    }
}
