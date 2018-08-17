<?php

namespace Wearesho\Bobra\Portmone\Direct;

use Wearesho\Bobra\Portmone\Direct\Collections\Payers;
use Wearesho\Bobra\Portmone\Direct\Entities\Payer;
use Wearesho\Bobra\Portmone\NotificationInterface;

/**
 * Class SystemRequest
 * @package Wearesho\Bobra\Portmone\Direct
 */
class InternalRequest implements \JsonSerializable, NotificationInterface
{
    /** @var string */
    protected $payee;

    /** @var Payers */
    protected $payers;

    public function __construct(string $payee, Payers $payers)
    {
        $this->payee = $payee;
        $this->payers = $payers;
    }

    public function jsonSerialize(): array
    {
        return [
            'payee' => $this->payee,
            'payers' => array_map(function (Payer $payer) {
                return $payer->jsonSerialize();
            }, $this->payers->jsonSerialize()),
        ];
    }

    public function getPayee(): string
    {
        return $this->payee;
    }

    public function getPayers(): Payers
    {
        return $this->payers;
    }
}
