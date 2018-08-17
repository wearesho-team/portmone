<?php

namespace Wearesho\Bobra\Portmone\Notification\Collections;

use Wearesho\Bobra\Portmone\Notification\Entities\ApprovedPayer;

/**
 * Class ApprovedPayers
 * @package Wearesho\Bobra\Portmone\Notification\Collections
 */
class ApprovedPayers extends Payers
{
    public function type(): string
    {
        return ApprovedPayer::class;
    }
}
