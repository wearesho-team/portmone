<?php

namespace Wearesho\Bobra\Portmone\Direct;

/**
 * Class ServerError
 * @package Wearesho\Bobra\Portmone\Direct
 */
class Error
{
    public const SYSTEM_ERROR = 0;
    public const NOTIFICATION_ERROR = 1;
    
    /** @var int */
    protected $code;

    /** @var string|null */
    protected $message;

    /** @var string|null */
    protected $documentId;

    public function __construct(int $code, string $message, string $documentId = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->documentId = $documentId;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getDocumentId(): ?string
    {
        return $this->documentId;
    }
}
