<?php

namespace Wearesho\Bobra\Portmone\Notification;

use Carbon\Carbon;

use Wearesho\Bobra\Portmone\Notification\Collections;
use Wearesho\Bobra\Portmone\Notification\Entities\BankData;
use Wearesho\Bobra\Portmone\Notification\Entities\BillData;
use Wearesho\Bobra\Portmone\Notification\Entities\CompanyData;
use Wearesho\Bobra\Portmone\Notification\Entities\PayerData;
use Wearesho\Bobra\Portmone\Notification\Entities\PayOrderData;
use Wearesho\Bobra\Portmone\NotificationInterface;

/**
 * Class Server
 * @package Wearesho\Bobra\Portmone\Notification
 */
class Server implements XmlTags
{
    /**
     * @param string $data
     *
     * @return NotificationInterface
     * @throws InvalidDataException
     */
    public function handle(string $data): NotificationInterface
    {
        $this->validateData($data);

        $xml = simplexml_load_string($data);
        $type = $xml->getName();

        switch ($type) {
            case static::REQUESTS:
                return new SystemRequest(
                    $xml->{static::PAYEE},
                    new Collections\Payers(array_map(function (\SimpleXMLElement $payerXml) {
                        return $this->fetchPayerData($payerXml);
                    }, $this->convertSimpleXmlToArray($xml->{static::PAYER})))
                );
            case static::BILLS:
                $bill = $xml->{static::BILL};

                return new SystemPayment(
                    $this->fetchCompanyData($bill),
                    $this->fetchBankData($bill),
                    $this->fetchBillData($bill)
                );
            case static::PAY_ORDERS:
                $payOrder = $xml->{static::PAY_ORDER};

                return new BankPayment(
                    new PayOrderData(
                        (int)$payOrder->{static::PAY_ORDER_ID},
                        Carbon::parse((string)$payOrder->{static::PAY_ORDER_DATE}),
                        (string)$payOrder->{static::PAY_ORDER_NUMBER},
                        (float)$payOrder->{static::PAY_ORDER_AMOUNT}
                    ),
                    $this->fetchCompanyData($payOrder),
                    $this->fetchBankData($payOrder),
                    new Collections\Bills(array_map(function (\SimpleXMLElement $bill) {
                        return $this->fetchBillData($bill);
                    }, $this->convertSimpleXmlToArray($payOrder->{static::BILLS}->{static::BILL})))
                );
            default:
                throw new InvalidDataException($data, 'Data contain invalid type');
        }
    }

    /**
     * @param string $data
     *
     * @throws InvalidDataException
     */
    protected function validateData(string $data)
    {
        try {
            $xml = simplexml_load_string($data);

            if ($xml === false) {
                throw new \Exception('Fail with load xml');
            }
        } catch (\Throwable $exception) {
            throw new InvalidDataException(
                $data,
                $exception->getMessage() . "\nData contain invalid xml",
                -1,
                $exception
            );
        }
    }

    private function fetchBillData(\SimpleXMLElement $element): BillData
    {
        return new Entities\BillData(
            (int)$element->{static::BILL_ID},
            (string)$element->{static::BILL_NUMBER},
            Carbon::parse((string)$element->{static::BILL_DATE}),
            Carbon::parse((string)$element->{static::PAY_DATE}),
            (string)$element->{static::BILL_PERIOD},
            (float)$element->{static::PAYED_AMOUNT},
            (float)$element->{static::PAYED_COMMISSION},
            (float)$element->{static::PAYED_DEBT},
            (string)$element->{static::AUTH_CODE},
            $this->fetchPayerData($element->{static::PAYER}),
            $this->fetchMeters($element)
        );
    }

    private function fetchBankData(\SimpleXMLElement $element): BankData
    {
        return new Entities\BankData(
            (string)$element->{static::BANK}->{static::BANK_NAME},
            (string)$element->{static::BANK}->{static::BANK_CODE},
            (string)$element->{static::BANK}->{static::BANK_ACCOUNT}
        );
    }

    private function fetchCompanyData(\SimpleXMLElement $element): CompanyData
    {
        return new Entities\CompanyData(
            (string)$element->{static::PAYEE}->{static::COMPANY_NAME},
            (string)$element->{static::PAYEE}->{static::COMPANY_CODE}
        );
    }

    private function fetchPayerData(\SimpleXMLElement $payer): PayerData
    {
        $attributes = (array)$payer->children();
        unset($attributes[static::CONTRACT_NUMBER]);

        return new PayerData(
            (string)$payer->{static::CONTRACT_NUMBER},
            $attributes
        );
    }

    private function fetchMeters(\SimpleXMLElement $element): Collections\Meters
    {
        return new Collections\Meters(
            array_map(function (\SimpleXMLElement $meterXml) {
                return new Entities\MeterData(
                    (string)$meterXml->{static::ITEM_TYPE},
                    (string)$meterXml->{static::ITEM_COUNTER},
                    (string)$meterXml->{static::ITEM_PREV_COUNTER},
                    (float)$meterXml->{static::ITEM_SUBSIDY},
                    (float)$meterXml->{static::ITEM_PAYED_DEBT},
                    (float)$meterXml->{static::ITEM_AMOUNT}
                );
            }, $this->convertSimpleXmlToArray($element->{static::ITEMS}->{static::ITEM}))
        );
    }

    /**
     * @param null|\SimpleXMLElement $element
     *
     * @return \SimpleXMLElement[]
     */
    private function convertSimpleXmlToArray(?\SimpleXMLElement $element): array
    {
        $items = [];

        if (is_null($element)) {
            return $items;
        };

        foreach ($element as $item) {
            $items[] = $item;
        }

        return $items;
    }
}
