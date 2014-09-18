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
        $correctObject = $this->getJsonFixture('testPropertyFacetConverter');

        /** @var PropertyFacet $propertyFacet */
        $propertyFacet = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            switch ($field) {
                case 'values':
                    $this->assertValues($value, $propertyFacet->get($field));
                    break;
                case 'ranges':
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

    /**
     * @param $name
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../fixtures/Converters/Metadata/Facet/' . $name . '.json'));
    }
}