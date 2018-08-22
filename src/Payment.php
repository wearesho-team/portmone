<?php

namespace Wearesho\Bobra\Portmone;

use Wearesho\Bobra\Payments;

/**
 * Class Payment
 * @package Wearesho\Bobra\Portmone
 */
class Payment implements Payments\PaymentInterface
{
    /** @var string */
    protected $payeeId;

    /** @var int */
    protected $orderId;

    /** @var int */
    protected $amount;

    /** @var string */
    protected $description;

    /** @var Payments\UrlPairInterface */
    protected $urlPair;

    /** @var string */
    protected $url;

    /** @var string */
    protected $language;

    /** @var string */
    protected $encoding;

    /** @var array */
    protected $attributes;

    public function __construct(
        string $payeeId,
        int $orderId,
        int $amount,
        Payments\UrlPairInterface $urlPair,
        string $language,
        string $url,
        array $attributes = [],
        ?string $description = '',
        ?string $encoding = 'UTF-8'
    ) {
        $this->payeeId = $payeeId;
        $this->orderId = $orderId;
        $this->amount = $amount;
        $this->urlPair = $urlPair;
        $this->url = $url;
        $this->attributes = $attributes;
        $this->description = $description;
        $this->language = $language;
        $this->encoding = $encoding;
    }

    public function getId(): int
    {
        return $this->orderId;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        $json = [
            'payee_id' => $this->payeeId,
            'shop_order_number' => $this->orderId,
            'bill_amount' => number_format($this->amount / 100, 2, '.', ''),
            'description' => $this->description,
            'success_url' => $this->urlPair->getGood(),
            'failure_url' => $this->urlPair->getBad(),
            'lang' => $this->language,
        ];

        if (!is_null($this->encoding)) {
            $json['encoding'] = $this->encoding;
        }

        if (!empty($this->attributes)) {
            $json = array_merge($json, $this->attributes);
        }

        return [
            'url' => $this->url,
            'data' => $json,
        ];
    }
}
