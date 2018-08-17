<?php

namespace Wearesho\Bobra\Portmone\Direct\Collections;

use Wearesho\Bobra\Portmone\Helpers\BaseCollection;
use Wearesho\Bobra\Portmone\Direct\Entities\PayerData;

/**
 * Class Payers
 * @package Wearesho\Bobra\Portmone\Direct\Collections
 */
class Payers extends BaseCollection
{
    public function type(): string
    {
        return PayerData::class;
    }
}
