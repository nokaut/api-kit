<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 13:40
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet;


use Nokaut\ApiKit\Entity\Metadata\Facet\CategoryFacet;
use PHPUnit\Framework\TestCase;

class CategoryFacetConverterTest extends TestCase
{
    public function testConvert()
    {
        $cut = new CategoryFacetConverter();
        $correctObject = $this->getMetadataFromApi();

        /** @var CategoryFacet $categoryFacet */
        $categoryFacet = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            $this->assertEquals($value, $categoryFacet->get($field));
        }
    }

    private function getMetadataFromApi()
    {
        return json_decode('
        {
            "id": 8444,
            "total": 116,
            "url": "/pozostale-aparaty-fotograficzne/",
            "name": "Pozostałe aparaty fotograficzne",
            "param": "pozostale-aparaty-fotograficzne",
            "subcategory_count": 37
        }
        ');
    }
}