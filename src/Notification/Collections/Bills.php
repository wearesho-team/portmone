<?php

namespace Wearesho\Bobra\Portmone\Notification\Collections;

use Wearesho\Bobra\Portmone\BaseCollection;
use Wearesho\Bobra\Portmone\Notification\Entities\BillData;

/**
 * Class Bills
 * @package Wearesho\Bobra\Portmone\Notification\Collections
 */
class Bills extends BaseCollection
{
    public function type(): string
    {
        return BillData::class;
    }
}
