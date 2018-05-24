<?php

namespace Wearesho\Bobra\Portmone;

use Wearesho\Bobra\Payments;

/**
 * Class Client
 * @package Wearesho\Bobra\Portmone
 */
class Client implements Payments\ClientInterface
{
    use ValidateLanguage;

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

    }

    /**
     * @param Payments\TransactionInterface $transaction
     * @throws \InvalidArgumentException
     * @return string
     */
    protected function fetchLanguage(Payments\TransactionInterface $transaction): string
    {
        if (!$transaction instanceof Payments\HasLanguage) {
            return $this->config->getLanguage();
        }

        $language = $transaction->getLanguage();
        $this->validateLanguage($language);

        return $language;
    }
}
