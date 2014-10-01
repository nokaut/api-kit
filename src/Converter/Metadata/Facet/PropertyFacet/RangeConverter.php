<?php
/**
 * Created by PhpStorm.
 * User: dwilkiewicz
 * Date: 16.09.2014
 * Time: 14:27
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet\PropertyFacet;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet\Range;

class RangeConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $rangeEntity = new Range();

        foreach ($object as $field => $value) {
            $rangeEntity->set($field, $value);
        }
        return $rangeEntity;
    }
}