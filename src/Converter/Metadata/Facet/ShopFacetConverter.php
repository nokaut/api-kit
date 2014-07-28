<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 13:54
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Facet\ShopFacet;

class ShopFacetConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $shopFacet = new ShopFacet();

        foreach ($object as $field => $value) {
            $shopFacet->set($field, $value);
        }
        return $shopFacet;
    }
}