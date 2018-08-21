<?php

namespace Wearesho\Bobra\Portmone\Direct\Entities;

use Wearesho\Bobra\Portmone\Direct\Message;

/**
 * Class RejectPayer
 * @package Wearesho\Bobra\Portmone\Direct\Entities
 */
class RejectPayer extends Payer
{
    /** @var Message */
    protected $error;

    public function __construct(Message $error, string $contractNumber, array $attributes = [])
    {
        $this->error = $error;

        parent::__construct($contractNumber, $attributes);
    }

    public function getError(): Message
    {
        return $this->error;
    }
}
