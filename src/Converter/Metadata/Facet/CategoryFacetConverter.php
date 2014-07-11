<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 13:26
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet;


use Nokaut\ApiKit\Converter\ConverterInterace;
use Nokaut\ApiKit\Entity\Metadata\Facet\CategoryFacet;

class CategoryFacetConverter implements ConverterInterace
{
    public function convert(\stdClass $object)
    {
        $categoryFacet = new CategoryFacet();

        foreach ($object as $field => $value) {
            $categoryFacet->set($field, $value);
        }
        return $categoryFacet;
    }
}