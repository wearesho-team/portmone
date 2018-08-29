<?php

namespace Wearesho\Bobra\Portmone\Credit;

use Carbon\Carbon;

use GuzzleHttp;

use Nekman\LuhnAlgorithm;

use Psr\Http\Message\ResponseInterface;

use Wearesho\Bobra\Payments\Credit;
use Wearesho\Bobra\Portmone\Config;
use Wearesho\Bobra\Portmone\Credit\Response\Result;

/**
 * Class Client
 * @package Wearesho\Bobra\Portmone\Credit
 */
class Client
{
    protected const BILL_CREATE = 'bills.create';
    protected const BILL_PAY = 'bills.pay';
    protected const ATTRIBUTE_STATUS = 'status';

    protected const TAG_RESPONSE_ROOT = 'rsp';
    protected const TAG_ERROR = 'error';
    protected const TAG_BILL = 'bill';
    protected const TAG_PAY_DATE = 'payDate';
    protected const TAG_PAY_AMOUNT = 'paidAmount';
    protected const TAG_STATUS = 'status';
    protected const TAG_PAYEE = 'payee';

    protected const ATTRIBUTE_CODE = 'code';
    protected const ATTRIBUTE_ID = 'id';

    /** @var Config */
    protected $config;

    /** @var GuzzleHttp\Client */
    protected $guzzleClient;

    /** @var LuhnAlgorithm\Contract\LuhnAlgorithmInterface */
    protected $luhn;

    public function __construct(Config $config, GuzzleHttp\Client $guzzleClient)
    {
        $this->config = $config;
        $this->guzzleClient = $guzzleClient;
        $this->luhn = LuhnAlgorithm\LuhnAlgorithmFactory::create();
    }

    /**
     * @param Credit\TransferInterface $creditToCard
     *
     * @return Credit\Response
     * @throws Credit\Exception
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function send(Credit\TransferInterface $creditToCard): Credit\Response
    {
        $this->validateCardNumber($creditToCard);

        $response = $this->guzzleClient->request('post', $this->config->getUrl(), [
            'login' => $this->config->getKey(),
            'password' => $this->config->getSecret(),
            'method' => static::BILL_CREATE,
            'payeeId' => $this->config->getPayee(),
            'contractNumber' => $creditToCard->getCardToken()
        ]);

        $document = $this->fetchResponseDocument($creditToCard, $response);

        $response = $this->guzzleClient->request('post', $this->config->getUrl(), [
            'login' => $this->config->getKey(),
            'password' => $this->config->getSecret(),
            'method' => static::BILL_PAY,
            'billId' => $document->{static::TAG_BILL}->attributes()[static::ATTRIBUTE_ID],
            'amount' => $creditToCard->getAmount()
        ]);

        $response = $this->fetchResponseDocument($creditToCard, $response);
        $bill = $response->{static::TAG_BILL};

        return new Payment(
            $bill->attributes()[static::ATTRIBUTE_ID],
            Carbon::createFromFormat('d.m.Y H:i:s', (string)$bill->{static::TAG_PAY_DATE}),
            (float)$bill->{static::TAG_PAY_AMOUNT},
            (string)$bill->{static::TAG_STATUS}
        );
    }

    /**
     * @param Credit\TransferInterface $creditToCard
     *
     * @throws Credit\Exception
     */
    protected function validateCardNumber(Credit\TransferInterface $creditToCard): void
    {
        $card = $creditToCard->getCardToken();

        if (!preg_match('/^\d{16}$/', $card)
            && !$this->luhn->isValid(LuhnAlgorithm\Number::fromString($card))) {
            throw new Credit\Exception($creditToCard, "Invalid card number");
        }
    }

    /**
     * @param string $payee
     *
     * @throws \Exception
     */
    protected function validatePayee(string $payee): void
    {
        if ($this->config->getPayee() !== $payee) {
            throw new \Exception("Incorrect payee id returned from Portmone service");
        }
    }

    /**
     * @param Credit\TransferInterface $creditToCard
     * @param ResponseInterface        $response
     *
     * @return \SimpleXMLElement
     * @throws BillException
     * @throws Credit\Exception
     * @throws \Exception
     */
    protected function fetchResponseDocument(
        Credit\TransferInterface $creditToCard,
        ResponseInterface $response
    ): \SimpleXMLElement {
        $responseBody = $response->getBody()->__toString();

        try {
            $responseXml = simplexml_load_string($responseBody);
        } catch (\Exception $exception) {
            throw new Credit\Exception(
                $creditToCard,
                "Invalid xml document.\nBODY: " . $responseBody,
                $exception->getCode(),
                $exception
            );
        }

        $responseStatus = $responseXml->attributes()[static::ATTRIBUTE_STATUS];

        if ((string)$responseStatus === Result::FAIL) {
            $error = $responseXml->{static::TAG_ERROR};

            throw new BillException(
                $creditToCard,
                $error->attributes()[static::ATTRIBUTE_CODE],
                (string)$error
            );
        }

        $this->validatePayee(
            $responseXml->{static::TAG_BILL}
            ->{static::TAG_PAYEE}
            ->attributes()[static::ATTRIBUTE_ID]
        );

        return $responseXml;
    }
}
