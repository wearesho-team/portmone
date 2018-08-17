<?php

namespace Wearesho\Bobra\Portmone\Helpers;

/**
 * Class Convert
 * @package Wearesho\Bobra\Portmone\Helpers
 */
class Convert
{
    /**
     * @param \SimpleXMLElement $element
     *
     * @return \SimpleXMLElement[]
     */
    public static function simpleXmlToArray(\SimpleXMLElement $element): array
    {
        $items = [];

        foreach ($element as $item) {
            $items[] = $item;
        }

        return $items;
    }
}
