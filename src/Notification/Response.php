<?php

namespace Wearesho\Bobra\Portmone\Notification;

use Wearesho\Bobra\Portmone\ConfigInterface;
use Wearesho\Bobra\Portmone\Notification\Collections\ApprovedPayers;
use Wearesho\Bobra\Portmone\Notification\Collections\Payers;

/**
 * Class Response
 * @package Wearesho\Bobra\Portmone\Notification
 */
class Response
{
    /** @var ConfigInterface */
    protected $config;

    /** @var ApprovedPayers */
    protected $approvedPayers;

    /** @var Payers */
    protected $rejectedPayers;

    /** @var string */
    protected $period;

    public function __construct(
        ConfigInterface $config,
        string $period,
        ApprovedPayers $approvedPayers,
        Payers $rejectedPayers
    ) {
        $this->config = $config;
        $this->approvedPayers = $approvedPayers;
        $this->rejectedPayers = $rejectedPayers;
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    public function getApprovedPayers(): ApprovedPayers
    {
        return $this->approvedPayers;
    }

    public function getRejectedPayers(): Payers
    {
        return $this->rejectedPayers;
    }

    public function toXml(): string
    {
        $document = new \DOMDocument('1.0', 'utf-8');
    }
}
