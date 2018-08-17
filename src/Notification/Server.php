<?php

namespace Wearesho\Bobra\Portmone\Notification;

use Carbon\Carbon;

use Wearesho\Bobra\Portmone\Notification\Collections;
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
                    $this->fetchPayers($xml)
                );
            case static::BILLS:
                $root = $xml->{static::BILL};

                return new SystemPayment(
                    new Entities\CompanyData(
                        (string)$root->{static::PAYEE}->{static::NAME},
                        (string)$root->{static::PAYEE}->{static::CODE}
                    ),
                    new Entities\BankData(
                        (string)$root->{static::BANK}->{static::NAME},
                        (string)$root->{static::BANK}->{static::CODE},
                        (string)$root->{static::BANK}->{static::ACCOUNT}
                    ),
                    new Entities\BillData(
                        (int)$root->{static::BILL_ID},
                        (string)$root->{static::BILL_NUMBER},
                        Carbon::parse((string)$root->{static::BILL_DATE}),
                        (string)$root->{static::BILL_PERIOD}
                    ),
                    Carbon::parse((string)$root->{static::PAY_DATE}),
                    (float)$root->{static::PAYED_AMOUNT},
                    (float)$root->{static::PAYED_COMMISSION},
                    (float)$root->{static::PAYED_DEBT},
                    (string)$root->{static::AUTH_CODE},
                    $this->fetchPayers($root),
                    $this->fetchMeters($root)
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

    /**
     * @param \SimpleXMLElement $element
     *
     * @return Collections\Payers
     */
    private function fetchPayers(\SimpleXMLElement $element): Collections\Payers
    {
        return new Collections\Payers(
            array_map(function (\SimpleXMLElement $payerXml) {
                return new Entities\PayerData(
                    (string)$payerXml->{static::CONTRACT_NUMBER},
                    $this->fetchAttributes($payerXml)
                );
            }, $this->convertSimpleXmlToArray($element->{static::PAYER}))
        );
    }

    private function fetchAttributes(\SimpleXMLElement $payer): array
    {
        $attributes = (array)$payer->children();
        unset($attributes[static::CONTRACT_NUMBER]);

        return $attributes;
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
