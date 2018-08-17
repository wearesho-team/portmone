<?php

namespace Wearesho\Bobra\Portmone\Direct;

/**
 * Class InvalidDataException
 * @package Wearesho\Bobra\Portmone\Direct
 */
class InvalidDataException extends \Exception
{
    /** @var string */
    protected $data;

    public function __construct(string $data, string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $this->data = $data;

        parent::__construct($message, $code, $previous);
    }

    public function getData(): string
    {
        return $this->data;
    }
}
