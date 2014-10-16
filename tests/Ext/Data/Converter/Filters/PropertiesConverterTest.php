<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters;

use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property\SetIsActive;

class PropertiesConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testPropertiesConverterWithoutCallbacks()
    {
        $productsConverter = new ProductsConverter();
        /** @var Products $products */
        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-filters-without-range'));

        $propertiesConverter = new PropertiesConverter();
        $properties = $propertiesConverter->convert($products, array());

        $this->assertEquals(count($products->getProperties()), count($properties));

        foreach ($properties as $property) {
            $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract', $property);
            $this->assertFalse($property->getIsActive());
        }
    }

    public function testPropertiesConverterWithCallbacks()
    {
        $productsConverter = new ProductsConverter();
        /** @var Products $products */
        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-filters-without-range'));

        $propertiesConverter = new PropertiesConverter();
        $properties = $propertiesConverter->convert($products, array(new SetIsActive()));

        $this->assertEquals(count($products->getProperties()), count($properties));

        foreach ($properties as $property) {
            $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract', $property);
            if ($property->getId() == 382) {
                $this->assertTrue($property->getIsActive());
            } else {
                $this->assertFalse($property->getIsActive());
            }
        }
    }

    /**
     * @param $name
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}
 