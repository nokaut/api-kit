<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 14:09
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet;


use Nokaut\ApiKit\Converter\ConverterInterace;
use Nokaut\ApiKit\Entity\Metadata\Facet\ProducerFacet;

class ProducerFacetConverter implements ConverterInterace
{
    public function convert(\stdClass $object)
    {
        $shopFacet = new ProducerFacet();

        foreach ($object as $field => $value) {
            $shopFacet->set($field, $value);
        }
        return $shopFacet;
    }
}