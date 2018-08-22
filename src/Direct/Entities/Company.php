<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

/**
 * Class Company
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
class Company implements \JsonSerializable
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $code;

    public function __construct(string $name, string $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
