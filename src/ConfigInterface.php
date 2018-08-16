<?php

namespace Wearesho\Bobra\Portmone;

use Wearesho\Bobra\Payments;

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

    /**
     * Default language, if transaction does not implement HasLanguage interface
     * @see Language
     * @see Payments\HasLanguage
     * @return string
     */
    public function getLanguage(): string;

    /**
     * Request url for sending response-data about payers
     * @see Notification\Client
     * @return string
     */
    public function getRequestUrl(): string;
}
