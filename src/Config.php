<?php

namespace Wearesho\Bobra\Portmone;

/**
 * Class Config
 * @package Wearesho\Bobra\Portmone
 */
class Config implements ConfigInterface
{
    use ConfigTrait, ValidateLanguage;

    public function __construct(
        string $key,
        string $secret,
        string $payee,
        string $language = Language::RU,
        string $url = 'https://www.portmone.com.ua/gateway/'
    ) {
        $this->key = $key;
        $this->secret = $secret;
        $this->payee = $payee;
        $this->url = $url;

        $this->validateLanguage($language);
        $this->language = $language;
    }
}
