<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

/**
 * Class Bank
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
class Bank implements \JsonSerializable
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $code;

    /** @var string */
    protected $account;

    public function __construct(string $name, string $code, string $account)
    {
        $this->name = $name;
        $this->code = $code;
        $this->account = $account;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'account' => $this->account,
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

    public function getAccount(): string
    {
        return $this->account;
    }
}
