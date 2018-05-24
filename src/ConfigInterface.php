<?php

namespace Wearesho\Bobra\Portmone;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Portmone
 */
interface ConfigInterface
{
    /**
     * Public key of the Portmone payment service
     * @return string
     */
    public function getKey(): string;

    /**
     * Private key of the Portmone payment service
     * @return string
     */
    public function getSecret(): string;

    /**
     * Payee ID needed for the Portmone API
     * @return string
     */
    public function getPayee(): string;
}
