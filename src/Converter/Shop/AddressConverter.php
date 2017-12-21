<?php

namespace Nokaut\ApiKit\Converter\Shop;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Shop\Address;

class AddressConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Address
     */
    public function convert(\stdClass $object)
    {
        $address = new Address();
        foreach ($object as $field => $value) {
            $address->set($field, $value);
        }
        return $address;
    }
}