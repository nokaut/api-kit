<?php

namespace Nokaut\ApiKit\Converter\Metadata\Products;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Products\Shops;

class ShopsConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Shops
     */
    public function convert(\stdClass $object)
    {
        $shops = new Shops();

        foreach ($object as $field => $value) {
            $shops->set($field, $value);
        }
        return $shops;
    }
}