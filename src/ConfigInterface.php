<?php

namespace Wearesho\Bobra\Portmone;

use Wearesho\Bobra\Payments;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Portmone
 */
interface ConfigInterface
{
    public const URL = 'https://www.portmone.com.ua/gateway/';

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

    public function getUrl(): string;
}
