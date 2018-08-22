<?php

namespace Wearesho\Bobra\Portmone\Direct\Collections;

use Wearesho\Bobra\Portmone\Direct\Entities\RejectPayer;
use Wearesho\Bobra\Portmone\Helpers\BaseCollection;

/**
 * Class RejectedPayers
 * @package Wearesho\Bobra\Portmone\Direct\Collections
 */
class RejectedPayers extends BaseCollection
{
    protected const TYPE = RejectPayer::class;
}
