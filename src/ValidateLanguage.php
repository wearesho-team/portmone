<?php

namespace Wearesho\Bobra\Portmone;

/**
 * Trait ValidateLanguage
 * @package Wearesho\Bobra\Portmone
 */
trait ValidateLanguage
{
    /**
     * @param string $language
     * @throws \InvalidArgumentException
     */
    protected function validateLanguage(string $language): void
    {
        $isLanguageValid = $language === Language::RU
            || $language === Language::UK
            || $language === Language::EN;

        if (!$isLanguageValid) {
            throw new \InvalidArgumentException("Unsupported language {$language}");
        }
    }
}
