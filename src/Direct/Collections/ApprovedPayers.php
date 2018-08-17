<?php

namespace Wearesho\Bobra\Portmone\Direct\Collections;

use Wearesho\Bobra\Portmone\Direct\Entities\ApprovedPayer;

/**
 * Class ApprovedPayers
 * @package Wearesho\Bobra\Portmone\Direct\Collections
 */
class ApprovedPayers extends Payers
{
    public function type(): string
    {
        return ApprovedPayer::class;
    }
}
