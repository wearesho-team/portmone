<?php

namespace Wearesho\Bobra\Portmone\Notification\Collections;

use Wearesho\Bobra\Portmone\Helpers\BaseCollection;
use Wearesho\Bobra\Portmone\Notification\Entities\MeterData;

/**
 * Class Meters
 * @package Wearesho\Bobra\Portmone\Notification\Collections
 */
class Meters extends BaseCollection
{
    public function type(): string
    {
        return MeterData::class;
    }
}
