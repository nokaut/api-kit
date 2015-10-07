<?php

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Entity\Producer;

class ProducerConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $producer = new Producer();
        foreach ($object as $field => $value) {
            $producer->set($field, $value);
        }

        return $producer;
    }
}