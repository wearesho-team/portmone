<?php

namespace Wearesho\Bobra\Portmone\Notification;

/**
 * Class InvalidBodyException
 *
 * @package Wearesho\Bobra\Portmone\Notification
 */
class InvalidBodyException extends \InvalidArgumentException
{
    /** @var string */
    protected $xml;

    public function __construct(string $xml, string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->xml = $xml;
    }

    public function getXml(): string
    {
        return $this->xml;
    }
}
