<?php

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Collection\Shops;

class ShopsConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Shops
     */
    public function convert(\stdClass $object)
    {
        $shopConverter = new ShopConverter();
        $shopsArray = array();
        foreach ($object->shops as $shopObject) {
            $shopsArray[] = $shopConverter->convert($shopObject);
        }

        return new Shops($shopsArray);
    }
}