<?php

namespace Wearesho\Bobra\Portmone\Helpers;

/**
 * Class Convert
 * @package Wearesho\Bobra\Portmone\Helpers
 */
class Convert
{
    public static function SimpleXmlToArray(\SimpleXMLElement $element): array
    {
        $items = [];

        foreach ($element as $item) {
            $items[] = $item;
        }

        return $items;
    }
}
