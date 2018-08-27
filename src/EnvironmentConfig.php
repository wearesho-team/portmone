<?php

namespace Wearesho\Bobra\Portmone;

use Horat1us\Environment;

/**
 * Class EnvironmentConfig
 * @package Wearesho\Bobra\Portmone
 */
class EnvironmentConfig extends Environment\Config implements ConfigInterface
{
    use ValidateLanguage;

    public function __construct(string $keyPrefix = 'PORTMONE_')
    {
        parent::__construct($keyPrefix);
    }

    public function getKey(): string
    {
        return $this->getEnv('KEY');
    }

    public function getSecret(): string
    {
        return $this->getEnv('SECRET');
    }

    public function getPayee(): string
    {
        return $this->getEnv('PAYEE');
    }

    public function getUrl(): string
    {
        return $this->getEnv('URL', ConfigInterface::URL);
    }

    public function getLanguage(): string
    {
        $url = $this->getEnv('LANGUAGE', Language::RU);

        $this->validateLanguage($url);

        return $url;
    }
}
