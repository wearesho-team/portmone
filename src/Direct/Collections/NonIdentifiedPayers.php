<?php

namespace Wearesho\Bobra\Portmone\Direct\Collections;

use Wearesho\Bobra\Portmone\Direct\Entities\RejectPayer;
use Wearesho\Bobra\Portmone\Helpers\BaseCollection;

/**
 * Class NonIdentifiedPayers
 * @package Wearesho\Bobra\Portmone\Direct\Collections
 */
class NonIdentifiedPayers extends BaseCollection
{
    protected const TYPE = RejectPayer::class;
}
