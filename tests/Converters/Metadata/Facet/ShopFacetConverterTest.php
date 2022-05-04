<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 13:58
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet;


use Nokaut\ApiKit\Entity\Metadata\Facet\ShopFacet;
use PHPUnit\Framework\TestCase;

class ShopFacetConverterTest extends TestCase
{
    public function testConvert()
    {
        $cut = new ShopFacetConverter();
        $correctObject = $this->getMetadataFromApi();

        /** @var ShopFacet $shopFacet */
        $shopFacet = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            $this->assertEquals($value, $shopFacet->get($field));
        }
    }

    private function getMetadataFromApi()
    {
        return json_decode('
        {
            "id": 23239,
            "name": "Saturn",
            "param": "saturn",
            "total": 257,
            "url": "/aparaty-fotograficzne/sklep:saturn-pl.html"

        }
        ');
    }
}