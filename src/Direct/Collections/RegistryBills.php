<?php

namespace Wearesho\Bobra\Portmone\Direct\Collections;

use Wearesho\Bobra\Portmone\Direct\Entities\RegistryBill;
use Wearesho\Bobra\Portmone\Helpers\BaseCollection;

/**
 * Class RegistryBills
 * @package Wearesho\Bobra\Portmone\Direct\Collections
 */
class RegistryBills extends BaseCollection
{
    protected const TYPE = RegistryBill::class;

    /** @var string */
    protected $payee;

    /** @var string */
    protected $period;

    public function __construct(
        string $payee,
        string $period,
        array $input = [],
        int $flags = 0,
        string $iterator_class = \ArrayIterator::class
    ) {
        $this->period = $period;
        $this->payee = $payee;

        parent::__construct($input, $flags, $iterator_class);
    }

    public function getPayee(): string
    {
        return $this->payee;
    }

    public function getPeriod(): string
    {
        return $this->period;
    }
}
