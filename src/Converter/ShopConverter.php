<?php

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Entity\Shop;

class ShopConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $shop = new Shop();
        foreach ($object as $field => $value) {
            $shop->set($field, $value);
        }

        return $shop;
    }
}