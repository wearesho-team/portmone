<?php

namespace Wearesho\Bobra\Portmone\Direct;

/**
 * Class Message
 * @package Wearesho\Bobra\Portmone\Direct
 */
class Message
{
    public const SYSTEM_ERROR = -2;
    public const NOTIFICATION_ERROR = -1;
    public const RESULT = -1;

    public const NO_ERROR = 0;

    public const PAYER_NOT_FOUNT = 1;
    public const TECH_ERROR = 2;
    public const PAYER_BLOCKED = 3;
    
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
