<?php

namespace Wearesho\Bobra\Portmone\Direct\XmlTags;

/**
 * Interface Payment
 * @package Wearesho\Bobra\Portmone\Direct\XmlTags
 */
interface Payment
{
    public const ID = 'BILL_ID';
    public const PAY_DATE = 'PAY_DATE';
    public const PAYED_AMOUNT = 'PAYED_AMOUNT';
    public const PAYED_COMMISSION = 'PAYED_COMMISSION';
    public const PAYED_DEBT = 'PAYED_DEBT';
    public const AUTH_CODE = 'AUTH_CODE';
}
