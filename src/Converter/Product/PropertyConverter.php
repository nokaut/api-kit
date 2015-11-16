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
        if (isset($object->is_fight)) {
            $property->setIsFight($object->is_fight);
        }
        if (isset($object->fight_sort)) {
            $property->setFightSort($object->fight_sort);
        }
        if (isset($object->fight_rating)) {
            $property->setFightRating($object->fight_rating);
        }
        if (isset($object->is_label)) {
            $property->setIsLabel($object->is_label);
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