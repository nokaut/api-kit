<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 02.09.2014
 * Time: 10:59
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet;


use Nokaut\ApiKit\Entity\Metadata\Facet\PhraseFacet;

class PhraseFacetConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvert()
    {
        $cut = new PhraseFacetConverter();
        $correctObject = $this->getMetadataFromApi();

        /** @var PhraseFacet $phraseFacet */
        $phraseFacet = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            $this->assertEquals($value, $phraseFacet->get($field));
        }
    }

    private function getMetadataFromApi()
    {
        return json_decode('
            {
                "value": "lenovo",
                "url_in_template": "/laptopy/produkt:%s,pamiec-ram:4+gb.html",
                "url_out": "/laptopy/pamiec-ram:4+gb.html",
                "url_category_template": "/laptopy/produkt:%s.html"
            }
            ');
    }
}