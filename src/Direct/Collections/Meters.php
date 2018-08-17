<?php

namespace Wearesho\Bobra\Portmone\Direct\Collections;

use Wearesho\Bobra\Portmone\Helpers\BaseCollection;
use Wearesho\Bobra\Portmone\Direct\Entities\Meter;

/**
 * Class Meters
 * @package Wearesho\Bobra\Portmone\Direct\Collections
 */
class Meters extends BaseCollection
{
    public function type(): string
    {
        return Meter::class;
    }
}
