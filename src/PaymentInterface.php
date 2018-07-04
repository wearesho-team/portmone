<?php

namespace Wearesho\Bobra\Portmone;

use Wearesho\Bobra\Payments;

interface PaymentInterface extends Payments\PaymentInterface
{
    public function getStatus(): string;
}
