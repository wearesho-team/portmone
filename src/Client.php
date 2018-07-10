<?php

namespace Wearesho\Bobra\Portmone;

use Wearesho\Bobra\Payments;

/**
 * Class Client
 * @package Wearesho\Bobra\Portmone
 */
class Client implements Payments\ClientInterface
{
    /** @var ConfigInterface */
    protected $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function createPayment(
        Payments\UrlPairInterface $pair,
        Payments\TransactionInterface $transaction
    ): Payments\PaymentInterface {

        $language = $transaction instanceof Payments\HasLanguage
            ? $transaction->getLanguage()
            : $this->config->getLanguage();

        return new Payment(
            $this->config->getPayee(),
            $transaction->getService(),
            $transaction->getAmount(),
            $pair,
            $language,
            $this->config->getUrl(),
            $transaction->getDescription()
        );
    }
}
