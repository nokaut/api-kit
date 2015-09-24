<?php

namespace Nokaut\ApiKit\Converter\Metadata\Products;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Products\Prices;

class PricesConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Prices
     */
    public function convert(\stdClass $object)
    {
        $prices = new Prices();

        foreach ($object as $field => $value) {
            $prices->set($field, $value);
        }
        return $prices;
    }
}