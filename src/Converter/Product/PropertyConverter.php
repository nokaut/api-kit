<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 20.06.2014
 * Time: 08:37
 */

namespace Nokaut\ApiKit\Converter\Product;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Product\Property;

class PropertyConverter implements ConverterInterface
{

    const SEPARATOR_PROPERTIES = '||';

    public function convert(\stdClass $object)
    {
        $property = new Property();
        $property->setId($object->id);
        $property->setName($object->name);
        $property->setValue($this->prepareValue($object));
        if (isset($object->unit)) {
            $property->setUnit($object->unit);
        }

        return $property;
    }

    /**
     * @param \stdClass $object
     * @return mixed
     */
    private function prepareValue(\stdClass $object)
    {
        if (strpos($object->value, self::SEPARATOR_PROPERTIES)) {
            return explode(self::SEPARATOR_PROPERTIES, $object->value);
        }
        return $object->value;
    }


} 