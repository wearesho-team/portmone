<?php

namespace Wearesho\Bobra\Portmone\Direct;

use Wearesho\Bobra\Portmone\Direct\Collections;

/**
 * Class Response
 * @package Wearesho\Bobra\Portmone\Direct
 */
class PayersResponse
{
    /** @var Collections\IdentifiedPayers */
    protected $identifiedPayers;

    /** @var Collections\RejectedPayers */
    protected $rejectedPayers;

    public function __construct(
        Collections\IdentifiedPayers $identifiedPayers,
        Collections\RejectedPayers $rejectedPayers
    ) {
        $this->identifiedPayers = $identifiedPayers;
        $this->rejectedPayers = $rejectedPayers;
    }

    public function getIdentifiedPayers(): Collections\IdentifiedPayers
    {
        return $this->identifiedPayers;
    }

    public function getRejectedPayers(): Collections\RejectedPayers
    {
        return $this->rejectedPayers;
    }
}
