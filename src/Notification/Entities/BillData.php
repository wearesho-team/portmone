<?php

namespace Wearesho\Bobra\Portmone\Notification\Entities;

use Carbon\Carbon;

/**
 * Class Bill
 * @package Wearesho\Bobra\Portmone\Notification\Entities
 */
class BillData implements \JsonSerializable
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $number;

    /** @var \DateTimeInterface */
    protected $date;

    /** @var string */
    protected $period;

    public function __construct(int $id, string $number, \DateTimeInterface $date, string $period)
    {
        $this->id = $id;
        $this->number = $number;
        $this->date = $date;
        $this->period = $period;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'date' => Carbon::instance($this->date)->toDateString(),
            'period' => $this->period
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getPeriod(): string
    {
        return $this->period;
    }
}
