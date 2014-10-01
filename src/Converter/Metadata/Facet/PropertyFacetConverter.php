<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 15:06
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Converter\Metadata\Facet\PropertyFacet\ValueConverter;
use Nokaut\ApiKit\Converter\Metadata\Facet\PropertyFacet\RangeConverter;
use Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet;

class PropertyFacetConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $propertyFacet = new PropertyFacet();

        foreach ($object as $field => $value) {
            switch ($field) {
                case 'values':
                    $propertyFacet->setValues($this->convertValues($value));
                    break;
                case 'ranges':
                    $propertyFacet->setRanges($this->convertRanges($value));
                    break;
                default:
                    $propertyFacet->set($field, $value);
                    break;
            }
        }
        return $propertyFacet;
    }

    private function convertValues(array $values)
    {
        $valueConverter = new ValueConverter();
        $result = array();
        foreach ($values as $value) {
            $result[] = $valueConverter->convert($value);
        }
        return $result;
    }

    private function convertRanges(array $ranges)
    {
        $rangeConverter = new RangeConverter();
        $result = array();
        foreach ($ranges as $range) {
            $result[] = $rangeConverter->convert($range);
        }
        return $result;
    }
}