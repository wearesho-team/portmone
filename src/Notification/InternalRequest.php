<?php

namespace Wearesho\Bobra\Portmone\Notification;

use Wearesho\Bobra\Portmone\Notification\Collections\Payers;
use Wearesho\Bobra\Portmone\Notification\Entities\PayerData;
use Wearesho\Bobra\Portmone\NotificationInterface;

/**
 * Class SystemRequest
 * @package Wearesho\Bobra\Portmone\Notification
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
            'payers' => array_map(function (PayerData $payer) {
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
