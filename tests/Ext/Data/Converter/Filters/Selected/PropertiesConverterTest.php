<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property\SetIsActive;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\FilterAbstract;

class PropertiesConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testPropertiesConverterWithoutCallbacks()
    {
        $productsConverter = new ProductsConverter();
        /** @var Products $products */
        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-filters-without-range'));

        $propertiesConverter = new PropertiesConverter();
        $properties = $propertiesConverter->convert($products, array());

        $this->assertEquals(1, count($properties));

        foreach ($properties as $property) {
            $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract', $property);

            foreach ($property as $value) {
                /** @var FilterAbstract $value */
                $this->assertTrue($value->getIsFilter());
            }
        }
    }

    public function testPropertiesConverterWithCallbacks()
    {
        $productsConverter = new ProductsConverter();
        /** @var Products $products */
        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-filters-without-range'));

        $propertiesConverter = new PropertiesConverter();
        $properties = $propertiesConverter->convert($products, array(new SetIsActive()));

        $this->assertEquals(1, count($properties));

        foreach ($properties as $property) {
            $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract', $property);

            foreach ($property as $value) {
                /** @var FilterAbstract $value */
                $this->assertTrue($value->getIsFilter());
            }
        }
    }

    /**
     * @param $name
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}
 