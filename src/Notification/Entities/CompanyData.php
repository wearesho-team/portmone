<?php

namespace Wearesho\Bobra\Portmone\Notification\Entities;

/**
 * Class Company
 * @package Wearesho\Bobra\Portmone\Notification\Entities
 */
class CompanyData implements \JsonSerializable
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
