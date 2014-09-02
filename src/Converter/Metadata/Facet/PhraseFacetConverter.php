<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 02.09.2014
 * Time: 10:52
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Facet\PhraseFacet;

class PhraseFacetConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $phraseFacet = new PhraseFacet();

        foreach ($object as $field => $value) {
            $phraseFacet->set($field, $value);
        }
        return $phraseFacet;
    }
} 