<?php

namespace Wearesho\Bobra\Portmone\Notification\Entities;

use Wearesho\Bobra\Portmone\NotificationInterface;

/**
 * Class BankPayment
 * @package Wearesho\Bobra\Portmone\Notification\Entities
 */
class BankPayment implements NotificationInterface
{
    public function getPayee(): string
    {
        return '1';
    }
}
