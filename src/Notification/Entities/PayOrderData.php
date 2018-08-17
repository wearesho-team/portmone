<?php

namespace Wearesho\Bobra\Portmone\Notification\Entities;

use Carbon\Carbon;

/**
 * Class PayOrder
 * @package Wearesho\Bobra\Portmone\Notification\Entities
 */
class PayOrderData implements \JsonSerializable
{
    /** @var int */
    protected $id;

    /** @var \DateTimeInterface */
    protected $date;

    /** @var string */
    protected $number;

    /** @var float */
    protected $amount;

    public function __construct(int $id, \DateTimeInterface $date, string $number, float $amount)
    {
        $this->id = $id;
        $this->date = $date;
        $this->number = $number;
        $this->amount = $amount;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'date' => Carbon::instance($this->date)->toDateString(),
            'number' => $this->number,
            'amount' => $this->amount,
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
