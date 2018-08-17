<?php

namespace Wearesho\Bobra\Portmone\Notification\Collections;

use Wearesho\Bobra\Portmone\Helpers\BaseCollection;
use Wearesho\Bobra\Portmone\Notification\Entities\PayerData;

/**
 * Class Payers
 * @package Wearesho\Bobra\Portmone\Notification\Collections
 */
class Payers extends BaseCollection
{
    public function type(): string
    {
        return PayerData::class;
    }
}
