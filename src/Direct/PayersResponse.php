<?php

namespace Wearesho\Bobra\Portmone\Direct;

use Wearesho\Bobra\Portmone\Direct\Collections;
use Wearesho\Bobra\Portmone\Direct\XmlTags\NonIdentifiedPayers;

/**
 * Class Response
 * @package Wearesho\Bobra\Portmone\Direct
 */
class PayersResponse
{
    /** @var Collections\IdentifiedPayers */
    protected $identifiedPayers;

    /** @var Collections\IdentifiedPayers */
    protected $rejectedPayers;

    public function __construct(
        Collections\IdentifiedPayers $identifiedPayers,
        NonIdentifiedPayers $rejectedPayers
    ) {
        $this->identifiedPayers = $identifiedPayers;
        $this->rejectedPayers = $rejectedPayers;
    }

    public function getIdentifiedPayers(): Collections\IdentifiedPayers
    {
        return $this->identifiedPayers;
    }

    public function getRejectedPayers(): Collections\IdentifiedPayers
    {
        return $this->rejectedPayers;
    }
}
