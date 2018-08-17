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
        string $language = Language::RU
    ) {
        $this->key = $key;
        $this->secret = $secret;
        $this->payee = $payee;

        $this->validateLanguage($language);
        $this->language = $language;
    }
}
