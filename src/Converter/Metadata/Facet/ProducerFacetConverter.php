<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 14:09
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Facet\ProducerFacet;

class ProducerFacetConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $producerFacet = new ProducerFacet();

        foreach ($object as $field => $value) {
            $producerFacet->set($field, $value);
        }
        return $producerFacet;
    }
}