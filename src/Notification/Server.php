<?php

namespace Wearesho\Bobra\Portmone\Notification;

use Carbon\Carbon;

use Wearesho\Bobra\Portmone\Helpers\Convert;
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
class Server
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
            case XmlTags::REQUESTS:
                return new InternalRequest(
                    $xml->{XmlTags::PAYEE},
                    new Collections\Payers(array_map(function (\SimpleXMLElement $payerXml) {
                        return $this->fetchPayerData($payerXml);
                    }, Convert::simpleXmlToArray($xml->{XmlTags::PAYER})))
                );
            case XmlTags::BILLS:
                $bill = $xml->{XmlTags::BILL};

                return new InternalPayment(
                    $this->fetchCompanyData($bill),
                    $this->fetchBankData($bill),
                    $this->fetchBillData($bill)
                );
            case XmlTags::PAY_ORDERS:
                $payOrder = $xml->{XmlTags::PAY_ORDER};

                return new BankPayment(
                    new PayOrderData(
                        (int)$payOrder->{XmlTags::PAY_ORDER_ID},
                        Carbon::parse((string)$payOrder->{XmlTags::PAY_ORDER_DATE}),
                        (string)$payOrder->{XmlTags::PAY_ORDER_NUMBER},
                        (float)$payOrder->{XmlTags::PAY_ORDER_AMOUNT}
                    ),
                    $this->fetchCompanyData($payOrder),
                    $this->fetchBankData($payOrder),
                    new Collections\Bills(array_map(function (\SimpleXMLElement $bill) {
                        return $this->fetchBillData($bill);
                    }, Convert::simpleXmlToArray($payOrder->{XmlTags::BILLS}->{XmlTags::BILL})))
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
            (int)$element->{XmlTags::BILL_ID},
            (string)$element->{XmlTags::BILL_NUMBER},
            Carbon::parse((string)$element->{XmlTags::BILL_DATE}),
            Carbon::parse((string)$element->{XmlTags::PAY_DATE}),
            (string)$element->{XmlTags::BILL_PERIOD},
            (float)$element->{XmlTags::PAYED_AMOUNT},
            (float)$element->{XmlTags::PAYED_COMMISSION},
            (float)$element->{XmlTags::PAYED_DEBT},
            (string)$element->{XmlTags::AUTH_CODE},
            $this->fetchPayerData($element->{XmlTags::PAYER}),
            $this->fetchMeters($element)
        );
    }

    private function fetchBankData(\SimpleXMLElement $element): BankData
    {
        return new Entities\BankData(
            (string)$element->{XmlTags::BANK}->{XmlTags::BANK_NAME},
            (string)$element->{XmlTags::BANK}->{XmlTags::BANK_CODE},
            (string)$element->{XmlTags::BANK}->{XmlTags::BANK_ACCOUNT}
        );
    }

    private function fetchCompanyData(\SimpleXMLElement $element): CompanyData
    {
        return new Entities\CompanyData(
            (string)$element->{XmlTags::PAYEE}->{XmlTags::COMPANY_NAME},
            (string)$element->{XmlTags::PAYEE}->{XmlTags::COMPANY_CODE}
        );
    }

    private function fetchPayerData(\SimpleXMLElement $payer): PayerData
    {
        $attributes = (array)$payer->children();
        unset($attributes[XmlTags::CONTRACT_NUMBER]);

        return new PayerData(
            (string)$payer->{XmlTags::CONTRACT_NUMBER},
            $attributes
        );
    }

    private function fetchMeters(\SimpleXMLElement $element): Collections\Meters
    {
        $meters = $element->{XmlTags::ITEMS}->{XmlTags::ITEM};

        return new Collections\Meters(
            $meters ?
                array_map(function (\SimpleXMLElement $meterXml) {
                    return new Entities\MeterData(
                        (string)$meterXml->{XmlTags::ITEM_TYPE},
                        (string)$meterXml->{XmlTags::ITEM_COUNTER},
                        (string)$meterXml->{XmlTags::ITEM_PREV_COUNTER},
                        (float)$meterXml->{XmlTags::ITEM_SUBSIDY},
                        (float)$meterXml->{XmlTags::ITEM_PAYED_DEBT},
                        (float)$meterXml->{XmlTags::ITEM_AMOUNT}
                    );
                }, $this->convertSimpleXmlToArray($meters))
                : []
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
