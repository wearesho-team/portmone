<?php

namespace Wearesho\Bobra\Portmone\Notification\Entities;

use MyCLabs\Enum\Enum;

/**
 * Class PayerType
 * @package Wearesho\Bobra\Portmone\Notification\Entities
 *
 * @method static static APPROVED()
 * @method static static REJECT()
 */
class PayerType extends Enum
{
    public const APPROVED = 1;
    public const REJECT = 2;
}
