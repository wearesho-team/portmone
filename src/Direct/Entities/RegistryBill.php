<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

use Wearesho\Bobra\Portmone\Direct\Collections\Meters;

/**
 * Class RegistryBill
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
class RegistryBill extends Bill
{
    /** @var string|null */
    protected $remark;

    public function __construct(
        Payer $payer,
        string $number,
        \DateTimeInterface
        $billDate,
        float $amount,
        float $debt,
        ?string $remark = null,
        Meters $meters = null
    ) {
        $this->remark = $remark;

        parent::__construct($payer, $number, $billDate, $amount, $debt, $meters);
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
