<?php

namespace Wearesho\Bobra\Portmone\Direct\XmlTags;

/**
 * Interface RejectedPayers
 * @package Wearesho\Bobra\Portmone\Direct\XmlTags
 */
interface RejectedPayers
{
    public const ROOT_COLLECTION = 'REJECTS';
    public const PAYEE = 'PAYEE';
    public const ROOT_SINGLE = 'REJECT';
}
