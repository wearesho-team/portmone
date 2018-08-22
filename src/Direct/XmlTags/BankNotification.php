<?php

namespace Wearesho\Bobra\Portmone\Direct\XmlTags;

/**
 * Interface BankNotification
 * @package Wearesho\Bobra\Portmone\Direct\XmlTags
 */
interface BankNotification
{
    public const ROOT = 'PAY_ORDER';
    public const ID = 'PAY_ORDER_ID';
    public const DATE = 'PAY_ORDER_DATE';
    public const NUMBER = 'PAY_ORDER_NUMBER';
    public const AMOUNT = 'PAY_ORDER_AMOUNT';
}
