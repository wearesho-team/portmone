<?php

namespace Wearesho\Bobra\Portmone\Notification;

/**
 * Interface XmlTags
 * @package Wearesho\Bobra\Portmone\Notification
 */
interface XmlTags
{
    public const REQUESTS = 'REQUESTS';
    public const RESPONSE = 'RESPONSE';
    public const PAY_ORDERS = 'PAY_ORDERS';

    public const PAYEE = 'PAYEE';
    public const COMPANY_NAME = 'NAME';
    public const COMPANY_CODE = 'CODE';

    public const PAYER = 'PAYER';
    public const CONTRACT_NUMBER = 'CONTRACT_NUMBER';
    /** @var string This is a prefix for tags: ATTRIBUTE1, ATTRIBUTE2 etc. */
    public const ATTRIBUTE = 'ATTRIBUTE';

    public const BILLS = 'BILLS';
    public const BILL = 'BILL';
    public const BILL_PERIOD = 'BILL_PERIOD';
    public const BILL_ID = 'BILL_ID';
    public const BILL_NUMBER = 'BILL_NUMBER';
    public const BILL_DATE = 'BILL_DATE';

    public const BANK = 'BANK';
    public const BANK_NAME = 'NAME';
    public const BANK_CODE = 'CODE';
    public const BANK_ACCOUNT = 'ACCOUNT';

    public const PAY_DATE = 'PAY_DATE';
    public const PAYED_AMOUNT = 'PAYED_AMOUNT';
    public const PAYED_COMMISSION = 'PAYED_COMMISSION';
    public const PAYED_DEBT = 'PAYED_DEBT';

    public const AUTH_CODE = 'AUTH_CODE';

    public const ITEMS = 'ITEMS';
    public const ITEM = 'ITEM';
    public const ITEM_TYPE = 'ITEM_TYPE';
    public const ITEM_AMOUNT = 'ITEM_AMOUNT';
    public const ITEM_SUBSIDY = 'ITEM_SUBSIDY';
    public const ITEM_COUNTER = 'ITEM_COUNTER';
    public const ITEM_PREV_COUNTER = 'ITEM_PREV_COUNTER';
    public const ITEM_PAYED_DEBT = 'ITEM_PAYED_DEBT';

    public const PAY_ORDER = 'PAY_ORDER';
    public const PAY_ORDER_ID = 'PAY_ORDER_ID';
    public const PAY_ORDER_DATE = 'PAY_ORDER_DATE';
    public const PAY_ORDER_NUMBER = 'PAY_ORDER_NUMBER';
    public const PAY_ORDER_AMOUNT = 'PAY_ORDER_AMOUNT';
}
