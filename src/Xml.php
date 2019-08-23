<?php
namespace Nataniel\BsxPrinter;

abstract class Xml
{
    /**
     * @param \SimpleXMLElement $parent
     * @param \SimpleXMLElement $node
     */
    public static function addChild(\SimpleXMLElement $parent, \SimpleXMLElement $node)
    {
        $new = $parent->addChild($node->getName(), (string)$node);
        foreach ($node->attributes() as $key => $value) {
            $new->addAttribute($key, $value);
        }

        foreach ($node->children() as $child) {
            self::addChild($new, $child);
        }
    }
}