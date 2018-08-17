<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

/**
 * Class RegistryMeter
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
class RegistryMeter extends Meter
{
    /** @var string|null */
    protected $description;

    /** @var string */
    protected $tariff;

    public function __construct(
        string $type,
        string $currentCounter,
        string $previousCounter,
        float $subsidy,
        float $debt,
        float $amount,
        string $tariff,
        ?string $description = null
    ) {
        $this->description = $description;
        $this->tariff = $tariff;

        parent::__construct($type, $currentCounter, $previousCounter, $subsidy, $debt, $amount);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getTariff(): string
    {
        return $this->tariff;
    }
}
