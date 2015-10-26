<?php

namespace Nokaut\ApiKit\Converter\Metadata\Products;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Products\Producers;

class ProducersConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Producers
     */
    public function convert(\stdClass $object)
    {
        $producers = new Producers();

        foreach ($object as $field => $value) {
            $producers->set($field, $value);
        }
        return $producers;
    }
}