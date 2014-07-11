<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 15:19
 */

namespace Nokaut\ApiKit\Converter\Metadata\Facet;


use Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet;

class PropertyFacetConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvert()
    {
        $cut = new PropertyFacetConverter();
        $correctObject = $this->getMetadataFromApi();

        /** @var PropertyFacet $propertyFacet */
        $propertyFacet = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            switch ($field) {
                case 'values':
                    $this->assertValues($value, $propertyFacet->get($field));
                    break;
                default:
                    $this->assertEquals($value, $propertyFacet->get($field));
                    break;
            }
        }
    }

    /**
     * @param array $correctObjectArray
     * @param array $objectToCheckArray
     */
    private function assertValues($correctObjectArray, $objectToCheckArray)
    {
        foreach ($correctObjectArray as $index => $correctObject) {
            foreach ($correctObject as $field => $value) {
                $this->assertEquals($value, $objectToCheckArray[$index]->get($field));
            }
        }
    }

    private function getMetadataFromApi()
    {
        return json_decode('
        {

            "id": 1545,
            "name": "Nagrywanie filmów",
            "unit": "",
            "values": [
                {
                    "name": "1920 x 1080 (Full HD)",
                    "total": 113,
                    "url": "/aparaty-cyfrowe/nagrywanie-filmow:1920-x-1080-full-hd.html"
                },
                {
                    "name": "1280 x 720 (HD)",
                    "total": 112,
                    "url": "/aparaty-cyfrowe/nagrywanie-filmow:1280-x-720-hd.html"
                },
                {
                    "name": "640 x 480",
                    "total": 4,
                    "url": "/aparaty-cyfrowe/nagrywanie-filmow:640-x-480.html"
                },
                {
                    "name": "320 x 240",
                    "total": 2,
                    "url": "/aparaty-cyfrowe/nagrywanie-filmow:320-x-240.html"
                }
            ]

        }
        ');
    }
}