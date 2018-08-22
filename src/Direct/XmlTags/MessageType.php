<?php

namespace Wearesho\Bobra\Portmone\Direct\XmlTags;

/**
 * Interface MessageType
 * @package Wearesho\Bobra\Portmone\Direct\XmlTags
 */
interface MessageType
{
    public const INTERNAL_REQUEST = 'REQUESTS';
    public const INTERNAL_RESPONSE = 'RESPONSE';
    public const INTERNAL_PAYMENT = 'BILLS';
    public const BANK_PAYMENTS = 'PAY_ORDERS';
    public const PAYMENT_RESPONSE = 'RESULT';
}
