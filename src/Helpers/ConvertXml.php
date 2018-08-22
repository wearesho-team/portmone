<?php

namespace Wearesho\Bobra\Portmone\Helpers;

use Carbon\Carbon;

/**
 * Class Convert
 * @package Wearesho\Bobra\Portmone\Helpers
 */
class ConvertXml
{
    /**
     * @param \SimpleXMLElement $element
     * @param string[]          $tagHierarchy
     *
     * @return array
     */
    public static function simpleXmlToArray(\SimpleXMLElement $element, $tagHierarchy = []): array
    {
        foreach ((array)$tagHierarchy as $tag) {
            $element = ((array)$element)[$tag];
        }

        return (array)$element;
    }

    public static function toInt(\SimpleXMLElement $element, $tagHierarchy = []): int
    {
        return (int)static::fetchSimpleXmlTagContent($element, $tagHierarchy);
    }

    public static function toFloat(\SimpleXMLElement $element, $tagHierarchy = []): float
    {
        return (float)static::fetchSimpleXmlTagContent($element, $tagHierarchy);
    }

    public static function toString(\SimpleXMLElement $element, $tagHierarchy = []): string
    {
        return (string)static::fetchSimpleXmlTagContent($element, $tagHierarchy);
    }

    public static function toCarbon(\SimpleXMLElement $element, $tagHierarchy = []): Carbon
    {
        return Carbon::parse(static::toString(static::fetchSimpleXmlTagContent($element, $tagHierarchy)));
    }

    private static function fetchSimpleXmlTagContent(\SimpleXMLElement $element, $tagHierarchy = []): \SimpleXMLElement
    {
        foreach ((array)$tagHierarchy as $tag) {
            $element = $element->{$tag};
        }

        return $element;
    }
}
