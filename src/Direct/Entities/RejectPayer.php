<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

use Wearesho\Bobra\Portmone\Direct\Error;

/**
 * Class RejectPayer
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
class RejectPayer extends Payer
{
    /** @var Error */
    protected $error;

    public function __construct(Error $error, string $contractNumber, array $attributes = [])
    {
        $this->error = $error;

        parent::__construct($contractNumber, $attributes);
    }

    public function getError(): Error
    {
        return $this->error;
    }
}
