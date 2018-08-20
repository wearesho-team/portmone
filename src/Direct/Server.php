<?php

namespace Wearesho\Bobra\Portmone\Direct;

use Carbon\Carbon;

use Wearesho\Bobra\Portmone\ConfigInterface;
use Wearesho\Bobra\Portmone\Direct\XmlTags\Payer;
use Wearesho\Bobra\Portmone\Helpers\Convert;
use Wearesho\Bobra\Portmone\NotificationInterface;

/**
 * Class Server
 * @package Wearesho\Bobra\Portmone\Direct
 */
class Server
{
    /** @var ConfigInterface */
    protected $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

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
            case XmlTags\MessageType::INTERNAL_REQUEST:
                return new InternalRequest(
                    Convert::simpleXmlToString($xml, XmlTags\Company::ROOT),
                    new Collections\Payers(array_map(function (\SimpleXMLElement $payerXml) {
                        return $this->fetchPayer($payerXml);
                    }, Convert::simpleXmlToArray($xml, XmlTags\Payer::ROOT)))
                );
            case XmlTags\MessageType::INTERNAL_PAYMENT:
                $bill = $this->fetchTagContent($xml, XmlTags\Bill::ROOT_SINGLE);

                return new InternalPaymentNotification(
                    $this->fetchInternalBill($bill)
                );
            case XmlTags\MessageType::BANK_PAYMENTS:
                $payOrder = $this->fetchTagContent($xml, XmlTags\BankNotification::ROOT);

                return new BankPayment(
                    new Entities\PayOrder(
                        Convert::simpleXmlToInt($payOrder, XmlTags\BankNotification::ID),
                        Convert::simpleXmlToCarbon($payOrder, XmlTags\BankNotification::DATE),
                        Convert::simpleXmlToString($payOrder, XmlTags\BankNotification::NUMBER),
                        Convert::simpleXmlToFloat($payOrder, XmlTags\BankNotification::AMOUNT)
                    ),
                    $this->fetchCompany($payOrder),
                    $this->fetchBank($payOrder),
                    $this->fetchOrderBills($payOrder)
                );
            default:
                throw new InvalidDataException($data, 'Data contain invalid type');
        }
    }

    /**
     * @param ResponseInterface $response
     *
     * @return string
     * @todo: finish implement
     */
    public function formResponse(ResponseInterface $response): string
    {
        $document = new \DOMDocument('1.0', 'utf-8');

        if ($response instanceof PayersResponse) {
            $identifiedPayers = $response->getIdentifiedPayers();

            $root = $document->createElement(XmlTags\MessageType::INTERNAL_RESPONSE);
            $payeeElement = $document->createElement(XmlTags\Company::ROOT, $this->config->getPayee());
            $periodElement = $document->createElement(XmlTags\Bill::PERIOD, $identifiedPayers->getPeriod());
            $billsCollectionRoot = $document->createElement(XmlTags\Bill::ROOT_COLLECTION);

            /** @var Entities\IdentifiedPayer $identifiedPayer */
            foreach ($identifiedPayers as $identifiedPayer) {
                $billRoot = $document->createElement(XmlTags\Bill::ROOT_SINGLE);
                $payerElement = $document->createElement(XmlTags\Payer::ROOT);
                $payerElement->appendChild($document->createElement(
                    XmlTags\Payer::CONTRACT_NUMBER,
                    $identifiedPayer->getPayer()->getContractNumber()
                ));

                foreach ($identifiedPayer->getPayer()->getAttributes() as $tag => $attribute) {
                    $payerElement->appendChild($document->createElement($tag, $attribute));
                }

                $billRoot->appendChild($payerElement);
                $billRoot->appendChild($document->createElement(
                    XmlTags\Bill::SET_DATE,
                    Carbon::instance($identifiedPayer->getSetDate())->toDateString()
                ));
                $billRoot->appendChild($document->createElement(
                    XmlTags\Bill::NUMBER,
                    $identifiedPayer->getNumber()
                ));
                $billRoot->appendChild($document->createElement(
                    XmlTags\Bill::AMOUNT,
                    $identifiedPayer->getAmount()
                ));
            }
        }

        return $document->saveXML();
    }

    /**
     * @param int   $errorType
     * @param Error $error
     *
     * @return string
     * @throws InvalidErrorTypeException
     */
    public function formError(int $errorType, Error $error): string
    {
        $document = new \DOMDocument('1.0', 'utf-8');

        switch ($errorType) {
            case Error::SYSTEM_ERROR:
                $root = $document->createElement(XmlTags\MessageType::INTERNAL_RESPONSE);
                $errorRoot = $document->createElement(XmlTags\Error::SYSTEM_ROOT);
                $codeElement = $document->createElement(XmlTags\Error::CODE, $error->getCode());
                $errorRoot->appendChild($codeElement);
                $messageElement = $document->createElement(XmlTags\Error::REASON, $error->getMessage());
                $errorRoot->appendChild($errorRoot->appendChild($messageElement));
                $root->appendChild($errorRoot);
                $document->appendChild($root);

                break;
            case Error::NOTIFICATION_ERROR:
                $root = $document->createElement(XmlTags\Error::NOTIFICATION_ROOT);
                $codeElement = $document->createElement(XmlTags\Error::CODE, $error->getCode());
                $messageElement = $document->createElement(XmlTags\Error::REASON, $error->getMessage());
                $documentIdElement = $document->createElement(XmlTags\Error::DOCUMENT_ID, $error->getDocumentId());
                $root->appendChild($codeElement);
                $root->appendChild($messageElement);
                $root->appendChild($documentIdElement);
                $document->appendChild($root);

                break;
            default:
                throw new InvalidErrorTypeException($errorType, $error);
        }

        return $document->saveXML();
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

    private function fetchOrderBills(\SimpleXMLElement $element): Collections\OrderBills
    {
        return new Collections\OrderBills(array_map(function (\SimpleXMLElement $bill) {
            return new Entities\OrderBill(
                Convert::simpleXmlToInt($bill, XmlTags\Bill::ID),
                Convert::simpleXmlToString($bill, XmlTags\Bill::PERIOD),
                Convert::simpleXmlToCarbon($bill, XmlTags\Payment::PAY_DATE),
                Convert::simpleXmlToFloat($bill, XmlTags\Payment::PAYED_COMMISSION),
                Convert::simpleXmlToString($bill, XmlTags\Payment::AUTH_CODE),
                $this->fetchPayer($this->fetchTagContent($bill, Payer::ROOT)),
                Convert::simpleXmlToString($bill, XmlTags\Bill::NUMBER),
                Convert::simpleXmlToCarbon($bill, XmlTags\Bill::SET_DATE),
                Convert::simpleXmlToFloat($bill, XmlTags\Payment::PAYED_AMOUNT),
                Convert::simpleXmlToFloat($bill, XmlTags\Payment::PAYED_DEBT)
            );
        }, Convert::simpleXmlToArray($element, [XmlTags\Bill::ROOT_COLLECTION, XmlTags\Bill::ROOT_SINGLE])));
    }

    private function fetchInternalBill(\SimpleXMLElement $element): Entities\InternalBill
    {
        return new Entities\InternalBill(
            Convert::simpleXmlToInt($element, XmlTags\Bill::ID),
            $this->fetchCompany($element),
            $this->fetchBank($element),
            Convert::simpleXmlToString($element, XmlTags\Bill::PERIOD),
            Convert::simpleXmlToCarbon($element, XmlTags\Payment::PAY_DATE),
            Convert::simpleXmlToFloat($element, XmlTags\Payment::PAYED_COMMISSION),
            Convert::simpleXmlToString($element, XmlTags\Payment::AUTH_CODE),
            $this->fetchPayer($this->fetchTagContent($element, Payer::ROOT)),
            Convert::simpleXmlToString($element, XmlTags\Bill::NUMBER),
            Convert::simpleXmlToCarbon($element, XmlTags\Bill::SET_DATE),
            Convert::simpleXmlToFloat($element, XmlTags\Payment::PAYED_AMOUNT),
            Convert::simpleXmlToFloat($element, XmlTags\Payment::PAYED_DEBT)
        );
    }

    private function fetchBank(\SimpleXMLElement $element): Entities\Bank
    {
        $bankXml = $this->fetchTagContent($element, XmlTags\Bank::ROOT);

        return new Entities\Bank(
            Convert::simpleXmlToString($bankXml, XmlTags\Bank::NAME),
            Convert::simpleXmlToString($bankXml, XmlTags\Bank::CODE),
            Convert::simpleXmlToString($bankXml, XmlTags\Bank::ACCOUNT)
        );
    }

    private function fetchCompany(\SimpleXMLElement $element): Entities\Company
    {
        $companyXml = $this->fetchTagContent($element, XmlTags\Company::ROOT);

        return new Entities\Company(
            Convert::simpleXmlToString($companyXml, XmlTags\Company::NAME),
            Convert::simpleXmlToString($companyXml, XmlTags\Company::CODE)
        );
    }

    private function fetchPayer(\SimpleXMLElement $element): Entities\Payer
    {
        $contractNumber = Convert::simpleXmlToString($element, XmlTags\Payer::CONTRACT_NUMBER);
        $attributes = Convert::simpleXmlToArray($element);
        unset($attributes[XmlTags\Payer::CONTRACT_NUMBER]);

        return new Entities\Payer(
            $contractNumber,
            $attributes
        );
    }

    /**
     * @param \SimpleXMLElement $element
     * @param string[]|string   $tags
     *
     * @return \SimpleXMLElement
     */
    private function fetchTagContent(\SimpleXMLElement $element, $tags)
    {
        foreach ((array)$tags as $tag) {
            $element = $element->{$tag};
        }

        return $element;
    }
}
