<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 14:22
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet;


use Nokaut\ApiKit\Entity\Metadata\Facet\PriceFacet;

class PriceFacetConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvert()
    {
        $cut = new PriceFacetConverter();
        $correctObject = $this->getMetadataFromApi();

        /** @var PriceFacet $priceFacet */
        $priceFacet = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            $this->assertEquals($value, $priceFacet->get($field));
        }
    }

    private function getMetadataFromApi()
    {
        return json_decode('
        {
            "min": 39.99,
            "max": 424,
            "total": 106,
            "url": "/aparaty-cyfrowe/cena:39.99~424.00.html"

        }
        ');
    }
}