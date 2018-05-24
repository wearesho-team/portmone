<?php

namespace Wearesho\Bobra\Portmone;

/**
 * Trait ConfigTrait
 * @package Wearesho\Bobra\Portmone
 */
trait ConfigTrait
{
    /** @var string */
    protected $key;

    /** @var string */
    protected $secret;

    /** @var string */
    protected $payee;

    /**
     * @inheritdoc
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @inheritdoc
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @inheritdoc
     */
    public function getPayee(): string
    {
        return $this->payee;
    }
}
