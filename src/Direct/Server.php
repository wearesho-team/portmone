<?php

namespace Wearesho\Bobra\Portmone\Direct;

use Carbon\Carbon;

use PHPUnit\Framework\Error\Error;
use Wearesho\Bobra\Portmone\ConfigInterface;
use Wearesho\Bobra\Portmone\Direct\Entities;
use Wearesho\Bobra\Portmone\Direct\XmlTags;
use Wearesho\Bobra\Portmone\Helpers\ConvertXml;
use Wearesho\Bobra\Portmone\NotificationInterface;
use Wearesho\Bobra\Portmone\Tests\Unit\Direct\ErrorTest;

/**
 * Class Server
 * @package Wearesho\Bobra\Portmone\Direct
 */
class Server
{
    private const OK = 'OK';

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
                    ConvertXml::toString($xml, XmlTags\Company::ROOT),
                    new Collections\Payers(array_map(function (\SimpleXMLElement $payerXml) {
                        return $this->fetchPayer($payerXml);
                    }, ConvertXml::simpleXmlToArray($xml, XmlTags\Payer::ROOT)))
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
                        ConvertXml::toInt($payOrder, XmlTags\BankNotification::ID),
                        ConvertXml::toCarbon($payOrder, XmlTags\BankNotification::DATE),
                        ConvertXml::toString($payOrder, XmlTags\BankNotification::NUMBER),
                        ConvertXml::toFloat($payOrder, XmlTags\BankNotification::AMOUNT)
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
     * @param PayersResponse $response
     *
     * @return string
     */
    public function getBodyPayersResponse(PayersResponse $response): string
    {
        $document = new \DOMDocument('1.0', 'utf-8');

        $root = $document->createElement(XmlTags\MessageType::INTERNAL_RESPONSE);

        $identifiedPayers = $response->getIdentifiedPayers();

        if (!empty($identifiedPayers)) {
            $billsCollectionRoot = $document->createElement(XmlTags\Bill::ROOT_COLLECTION);

            $billsCollectionRoot->appendChild($document->createElement(
                XmlTags\Company::ROOT,
                $this->config->getPayee()
            ));
            $billsCollectionRoot->appendChild($document->createElement(
                XmlTags\Bill::PERIOD,
                $identifiedPayers->getPeriod()
            ));

            /** @var Entities\IdentifiedPayer $bill */
            foreach ($identifiedPayers as $bill) {
                $billRoot = $document->createElement(XmlTags\Bill::ROOT_SINGLE);
                $payerElement = $document->createElement(XmlTags\Payer::ROOT);
                $payerElement->appendChild($document->createElement(
                    XmlTags\Payer::CONTRACT_NUMBER,
                    $bill->getPayer()->getContractNumber()
                ));

                $attributeIndex = 0;

                foreach ($bill->getPayer()->getAttributes() as $attribute) {
                    $payerElement->appendChild($document->createElement(
                        XmlTags\Payer::ATTRIBUTE . ++$attributeIndex,
                        $attribute
                    ));
                }

                $billRoot->appendChild($payerElement);
                $billRoot->appendChild($document->createElement(
                    XmlTags\Bill::SET_DATE,
                    Carbon::instance($bill->getSetDate())->toDateString()
                ));
                $billRoot->appendChild($document->createElement(
                    XmlTags\Bill::NUMBER,
                    $bill->getNumber()
                ));
                $billRoot->appendChild($document->createElement(
                    XmlTags\Bill::AMOUNT,
                    $bill->getAmount()
                ));
                $billRoot->appendChild($document->createElement(
                    XmlTags\Bill::DEBT,
                    $bill->getDebt()
                ));
                $billRoot->appendChild($document->createElement(
                    XmlTags\Bill::REMARK,
                    $bill->getRemark()
                ));

                $billsCollectionRoot->appendChild($billRoot);
            }

            $root->appendChild($billsCollectionRoot);
        }

        $rejectedPayers = $response->getRejectedPayers();

        if (!empty($rejectedPayers)) {
            $rejectCollectionRoot = $document->createElement(XmlTags\RejectedPayers::ROOT_COLLECTION);
            $rejectCollectionRoot->appendChild($document->createElement(
                XmlTags\RejectedPayers::PAYEE,
                $this->config->getPayee()
            ));

            /** @var Entities\RejectPayer $payer */
            foreach ($rejectedPayers as $payer) {
                $rejectSingleRoot = $document->createElement(XmlTags\RejectedPayers::ROOT_SINGLE);
                $payerRoot = $document->createElement(XmlTags\Payer::ROOT);
                $payerRoot->appendChild($document->createElement(
                    XmlTags\Payer::CONTRACT_NUMBER,
                    $payer->getContractNumber()
                ));

                $attributeIndex = 0;

                foreach ($payer->getAttributes() as $attribute) {
                    $payerRoot->appendChild($document->createElement(
                        XmlTags\Payer::ATTRIBUTE . ++$attributeIndex,
                        $attribute
                    ));
                }

                $rejectSingleRoot->appendChild($payerRoot);
                $error = $payer->getError();
                $rejectSingleRoot->appendChild($document->createElement(
                    XmlTags\Error::CODE,
                    $error->getCode()
                ));
                $rejectSingleRoot->appendChild($document->createElement(
                    XmlTags\Error::MESSAGE,
                    $error->getMessage()
                ));
                $rejectCollectionRoot->appendChild($rejectSingleRoot);
            }

            $root->appendChild($rejectCollectionRoot);
        }

        $document->appendChild($root);

        return $document->saveXML();
    }

    /**
     * @param string $documentId
     *
     * @return string
     * @throws InvalidErrorTypeException
     */
    public function getBodyNotificationResponse(string $documentId): string
    {
        return $this->getBodyMessage(
            Message::RESULT,
            new Message(Message::NO_ERROR, static::OK, $documentId)
        );
    }

    /**
     * @param int     $messageType
     * @param Message $error
     *
     * @return string
     * @throws InvalidErrorTypeException
     */
    public function getBodyMessage(int $messageType, Message $error): string
    {
        $document = new \DOMDocument('1.0', 'utf-8');

        switch ($messageType) {
            case Message::SYSTEM_ERROR:
                $root = $document->createElement(XmlTags\MessageType::INTERNAL_RESPONSE);
                $errorRoot = $document->createElement(XmlTags\Error::SYSTEM_ROOT);
                $errorRoot->appendChild($document->createElement(
                    XmlTags\Error::CODE,
                    $error->getCode()
                ));
                $errorRoot->appendChild($document->createElement(
                    XmlTags\Error::REASON,
                    $error->getMessage()
                ));
                $root->appendChild($errorRoot);

                break;
            case Message::NOTIFICATION_ERROR:
                $root = $document->createElement(XmlTags\Error::NOTIFICATION_ROOT);
                $root->appendChild($document->createElement(
                    XmlTags\Error::CODE,
                    $error->getCode()
                ));
                $root->appendChild($document->createElement(
                    XmlTags\Error::REASON,
                    $error->getMessage()
                ));
                $root->appendChild($document->createElement(
                    XmlTags\Error::DOCUMENT_ID,
                    $error->getDocumentId()
                ));

                break;
            default:
                throw new InvalidErrorTypeException($messageType, $error);
        }

        $document->appendChild($root);

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
                ConvertXml::toInt($bill, XmlTags\Bill::ID),
                ConvertXml::toString($bill, XmlTags\Bill::PERIOD),
                ConvertXml::toCarbon($bill, XmlTags\Payment::PAY_DATE),
                ConvertXml::toFloat($bill, XmlTags\Payment::PAYED_COMMISSION),
                ConvertXml::toString($bill, XmlTags\Payment::AUTH_CODE),
                $this->fetchPayer($this->fetchTagContent($bill, XmlTags\Payer::ROOT)),
                ConvertXml::toString($bill, XmlTags\Bill::NUMBER),
                ConvertXml::toCarbon($bill, XmlTags\Bill::SET_DATE),
                ConvertXml::toFloat($bill, XmlTags\Payment::PAYED_AMOUNT),
                ConvertXml::toFloat($bill, XmlTags\Payment::PAYED_DEBT)
            );
        }, ConvertXml::simpleXmlToArray($element, [XmlTags\Bill::ROOT_COLLECTION, XmlTags\Bill::ROOT_SINGLE])));
    }

    private function fetchInternalBill(\SimpleXMLElement $element): Entities\InternalBill
    {
        return new Entities\InternalBill(
            ConvertXml::toInt($element, XmlTags\Bill::ID),
            $this->fetchCompany($element),
            $this->fetchBank($element),
            ConvertXml::toString($element, XmlTags\Bill::PERIOD),
            ConvertXml::toCarbon($element, XmlTags\Payment::PAY_DATE),
            ConvertXml::toFloat($element, XmlTags\Payment::PAYED_COMMISSION),
            ConvertXml::toString($element, XmlTags\Payment::AUTH_CODE),
            $this->fetchPayer($this->fetchTagContent($element, XmlTags\Payer::ROOT)),
            ConvertXml::toString($element, XmlTags\Bill::NUMBER),
            ConvertXml::toCarbon($element, XmlTags\Bill::SET_DATE),
            ConvertXml::toFloat($element, XmlTags\Payment::PAYED_AMOUNT),
            ConvertXml::toFloat($element, XmlTags\Payment::PAYED_DEBT)
        );
    }

    private function fetchBank(\SimpleXMLElement $element): Entities\Bank
    {
        $bankXml = $this->fetchTagContent($element, XmlTags\Bank::ROOT);

        return new Entities\Bank(
            ConvertXml::toString($bankXml, XmlTags\Bank::NAME),
            ConvertXml::toString($bankXml, XmlTags\Bank::CODE),
            ConvertXml::toString($bankXml, XmlTags\Bank::ACCOUNT)
        );
    }

    private function fetchCompany(\SimpleXMLElement $element): Entities\Company
    {
        $companyXml = $this->fetchTagContent($element, XmlTags\Company::ROOT);

        return new Entities\Company(
            ConvertXml::toString($companyXml, XmlTags\Company::NAME),
            ConvertXml::toString($companyXml, XmlTags\Company::CODE)
        );
    }

    private function fetchPayer(\SimpleXMLElement $element): Entities\Payer
    {
        $contractNumber = ConvertXml::toString($element, XmlTags\Payer::CONTRACT_NUMBER);
        $attributes = ConvertXml::simpleXmlToArray($element);
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
