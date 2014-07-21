<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 13:00
 */

namespace Nokaut\ApiKit\Converter\Offer;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Offer\Property;

class PropertyConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $property = new Property();
        foreach ($object as $field => $value) {
            $property->set($field, $value);
        }
        return $property;
    }

} 