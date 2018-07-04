<?php

namespace Wearesho\Bobra\Portmone;

use Wearesho\Bobra\Payments\PaymentInterface;
use Wearesho\Bobra\Payments\PaymentTrait;
use Wearesho\Bobra\Payments\UrlPairInterface;

/**
 * Class Payment
 *
 * @package Wearesho\Bobra\Portmone
 */
class Payment implements PaymentInterface
{
    use PaymentTrait;

    public const TYPE = null;

    /** @var string */
    protected $lang;

    /** @var UrlPairInterface */
    protected $urlPair;

    /** @var string */
    protected $sign;

    /** @var string */
    protected $key;

    /** @var array */
    protected $ext = [];

    /** @var string */
    protected $formUrl;

    public function __construct(
        int $id,
        string $lang,
        UrlPairInterface $urlPair,
        $sign,
        $key,
        $formUrl,
        $ext
    )
    {
        $this->id = $id;
        $this->lang = $lang;
        $this->urlPair = $urlPair;
        $this->sign = $sign;
        $this->ext = $ext;
        $this->formUrl = $formUrl;
        $this->key = $key;
    }

    public function jsonSerialize(): array
    {
        $json = [
            'key' => $this->key,
            'payment' => static::TYPE,
            'url' => $this->urlPair->getGood(),
            'error_url' => $this->urlPair->getBad(),
            'lang' => $this->lang,
            'sign' => $this->sign,
        ];

        if (!empty($this->ext)) {
            $json = array_merge($json, $this->ext);
        }

        return [
            'action' => $this->formUrl,
            'data' => $json,
        ];
    }
}
