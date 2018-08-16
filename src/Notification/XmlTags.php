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
    public const NAME = 'NAME';
    public const CODE = 'CODE';
    public const ACCOUNT = 'ACCOUNT';

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
}
