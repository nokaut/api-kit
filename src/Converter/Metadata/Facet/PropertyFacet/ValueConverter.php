<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 15:13
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet\PropertyFacet;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet\Value;

class ValueConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $valueEntity = new Value();

        foreach ($object as $field => $value) {
            $valueEntity->set($field, $value);
        }
        return $valueEntity;
    }
}