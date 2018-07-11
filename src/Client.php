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
            $this->transformInfoToAttributes($transaction->getInfo()),
            $transaction->getDescription()
        );
    }

    protected function transformInfoToAttributes(array $info): array
    {
        $max = null;
        $result = [];

        foreach ($info as $key => $value) {
            if (is_int($key)) {
                $max = max($key, $max);
            } else {
                $key = ++$max;
            }

            $result['attribute' . $key] = $value;
        }

        return $result;
    }
}
