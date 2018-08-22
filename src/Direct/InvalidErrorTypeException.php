<?php

namespace Wearesho\Bobra\Portmone\Direct;

/**
 * Class InvalidErrorType
 * @package Wearesho\Bobra\Portmone\Direct
 */
class InvalidErrorTypeException extends \Exception
{
    /** @var int */
    protected $errorType;

    /** @var Message */
    protected $errorContent;

    public function __construct(
        int $errorType,
        Message $errorContent,
        string $message = "",
        int $code = 0,
        \Throwable $previous = null
    ) {
        $this->errorType = $errorType;
        $this->errorContent = $errorContent;

        parent::__construct($message, $code, $previous);
    }

    public function getErrorType(): int
    {
        return $this->errorType;
    }

    public function getErrorContent(): Message
    {
        return $this->errorContent;
    }
}
