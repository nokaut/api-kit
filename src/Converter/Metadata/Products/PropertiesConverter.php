<?php

namespace Nokaut\ApiKit\Converter\Metadata\Products;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Products\Properties;

class PropertiesConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Properties
     */
    public function convert(\stdClass $object)
    {
        $properties = new Properties();

        foreach ($object as $field => $value) {
            $properties->set($field, $value);
        }
        return $properties;
    }
}