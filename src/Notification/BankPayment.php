<?php

namespace Wearesho\Bobra\Portmone\Notification;

use Wearesho\Bobra\Portmone\NotificationInterface;

/**
 * Class BankPayment
 * @package Wearesho\Bobra\Portmone\Notification
 *
 * @todo: implement
 */
class BankPayment implements NotificationInterface
{
    public function getPayee(): string
    {
        return '1';
    }
}
