<?php

namespace Wearesho\Bobra\Portmone;

use Wearesho\Bobra\Payments;

/**
 * Trait PaymentTrait
 *
 * @package Wearesho\Bobra\Portmone
 */
trait PaymentTrait
{
    use Payments\PaymentTrait;

    /** @var string */
    protected $status;

    public function getStatus(): string
    {
        return $this->status;
    }
}
