<?php

namespace Wearesho\Bobra\Portmone\Direct\XmlTags;

/**
 * Interface Bill
 * @package Wearesho\Bobra\Portmone\Direct\XmlTags
 */
interface Bill
{
    public const ROOT_COLLECTION = 'BILLS';
    public const ROOT_SINGLE = 'BILL';
    public const PAYEE = 'PAYEE';
    public const ID = 'BILL_ID';
    public const PERIOD = 'BILL_PERIOD';
    public const SET_DATE = 'BILL_DATE';
    public const NUMBER = 'BILL_NUMBER';
    public const AMOUNT = 'AMOUNT';
    public const DEBT = 'DEBT';
    public const REMARK = 'REMARK';
}
