<?php

namespace Wearesho\Bobra\Portmone\Direct\Collections;

use Wearesho\Bobra\Portmone\Helpers\BaseCollection;
use Wearesho\Bobra\Portmone\Direct\Entities\MeterData;

/**
 * Class Meters
 * @package Wearesho\Bobra\Portmone\Direct\Collections
 */
class Meters extends BaseCollection
{
    public function type(): string
    {
        return MeterData::class;
    }
}
