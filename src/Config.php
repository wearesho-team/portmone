<?php

namespace Wearesho\Bobra\Portmone;

/**
 * Class Config
 * @package Wearesho\Bobra\Portmone
 */
class Config implements ConfigInterface
{
    use ConfigTrait;

    public function __construct(string $key, string $secret, string $payee)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->payee = $payee;
    }
}
