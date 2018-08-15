<?php

namespace Wearesho\Bobra\Portmone\Credit;

use GuzzleHttp\ClientInterface;

use Wearesho\Bobra\Payments\Credit\TransferInterface;
use Wearesho\Bobra\Portmone\ConfigInterface;

/**
 * Class Client
 * @package Wearesho\Bobra\Portmone\Credit
 */
class Client
{
    /** @var ClientInterface */
    protected $guzzleClient;

    /** @var ConfigInterface */
    protected $config;

    public function __construct(ClientInterface $client, ConfigInterface $config)
    {
        $this->guzzleClient = $client;
        $this->config = $config;
    }

    public function send(TransferInterface $credit): Response
    {
        
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }
}
