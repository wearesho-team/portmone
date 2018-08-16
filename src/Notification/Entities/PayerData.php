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

    /** @var PayerType|null */
    protected $type;

    public function __construct(string $contractNumber, array $attributes = [], PayerType $type = null)
    {
        $this->contractNumber = $contractNumber;
        $this->attributes = $attributes;
        $this->type = $type;
    }

    public function jsonSerialize(): array
    {
        $json = [
            'contractNumber' => $this->contractNumber,
            'attributes' => $this->attributes,
        ];

        if ($this->type) {
            $json['type'] = $this->type->getKey();
        }

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

    public function getType(): ?PayerType
    {
        return $this->type;
    }
}
