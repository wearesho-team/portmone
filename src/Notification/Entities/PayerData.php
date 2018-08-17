<?php

namespace Wearesho\Bobra\Portmone\Notification\Entities;

/**
 * Class Payer
 * @package Wearesho\Bobra\Portmone\Notification\Entities
 */
class PayerData implements \JsonSerializable
{
    /** @var string */
    protected $contractNumber;

    /** @var array */
    protected $attributes;

    public function __construct(string $contractNumber, array $attributes = [])
    {
        $this->contractNumber = $contractNumber;
        $this->attributes = $attributes;
    }

    public function jsonSerialize(): array
    {
        $json = [
            'contractNumber' => $this->contractNumber,
            'attributes' => $this->attributes,
        ];

        return $json;
    }

    public function getContractNumber(): string
    {
        return $this->contractNumber;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
