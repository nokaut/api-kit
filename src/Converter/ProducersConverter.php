<?php

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Collection\Producers;

class ProducersConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Producers
     */
    public function convert(\stdClass $object)
    {
        $producerConverter = new ProducerConverter();
        $producersArray = array();
        foreach ($object->producers as $producerObject) {
            $producersArray[] = $producerConverter->convert($producerObject);
        }

        return new Producers($producersArray);
    }
}