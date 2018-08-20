<?php

namespace Wearesho\Bobra\Portmone\Direct\XmlTags;

/**
 * Interface Error
 * @package Wearesho\Bobra\Portmone\Direct\XmlTags
 */
interface Error
{
    public const NOTIFICATION_ROOT = 'RESULT';
    public const SYSTEM_ROOT = 'SYSTEM_ERROR';
    public const CODE = 'ERROR_CODE';
    public const MESSAGE = 'ERROR_MESSAGE';
    public const REASON = 'REASON';
    public const DOCUMENT_ID = 'TRN_ID';
}
