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

    /** @var Error */
    protected $errorContent;

    public function __construct(
        int $errorType,
        Error $errorContent,
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

    public function getErrorContent(): Error
    {
        return $this->errorContent;
    }
}
