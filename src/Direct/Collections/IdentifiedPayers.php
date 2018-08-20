<?php

namespace Wearesho\Bobra\Portmone\Direct\Collections;

use Wearesho\Bobra\Portmone\Direct\Entities\IdentifiedPayer;
use Wearesho\Bobra\Portmone\Helpers\BaseCollection;

/**
 * Class RegistryBills
 * @package Wearesho\Bobra\Portmone\Direct\Collections
 */
class IdentifiedPayers extends BaseCollection
{
    protected const TYPE = IdentifiedPayer::class;

    /** @var string */
    protected $period;

    public function __construct(
        string $period,
        array $input = [],
        int $flags = 0,
        string $iterator_class = \ArrayIterator::class
    ) {
        $this->period = $period;

        parent::__construct($input, $flags, $iterator_class);
    }

    public function getPeriod(): string
    {
        return $this->period;
    }
}
