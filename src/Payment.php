<?php

namespace Wearesho\Bobra\Portmone;

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

    public function __construct(
        int $id,
        string $lang,
        UrlPairInterface $urlPair
    )
    {
        $this->id = $id;
        $this->lang = $lang;
        $this->urlPair = $urlPair;
    }

    public function jsonSerialize(): array
    {
        return [
            'data' => [
                'payment' => static::TYPE,
                'url' => $this->urlPair->getGood(),
                'error_url' => $this->urlPair->getBad(),
                'lang' => $this->lang,
            ]
        ];
    }
}
