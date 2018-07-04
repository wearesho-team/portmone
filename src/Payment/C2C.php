<?php

namespace Wearesho\Bobra\Portmone\Payment;

use Wearesho\Bobra\Payments\UrlPairInterface;
use Wearesho\Bobra\Portmone;

/**
 * Class C2C
 *
 * @package Wearesho\Bobra\Portmone\Payment
 */
class C2C extends Portmone\Payment
{
    public const TYPE = 'C2C';

    /** @var string */
    protected $data;

    public function __construct(
        int $id,
        string $lang,
        UrlPairInterface $urlPair,
        string $sign,
        string $key,
        string $formUrl,
        string $data,
        array $ext = []
    )
    {
        parent::__construct($id, $lang, $urlPair, $sign, $key, $formUrl, $ext);
        $this->data = $data;
    }

    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json['data'] = array_merge($json['data'] ?? [], [
            'data' => $this->data,
        ]);

        return $json;
    }
}
