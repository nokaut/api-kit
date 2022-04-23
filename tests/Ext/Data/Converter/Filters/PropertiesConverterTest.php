<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property\SetIsActive;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PropertyRange;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PropertyValue;
use PHPUnit\Framework\TestCase;
use stdClass;

class PropertiesConverterTest extends TestCase
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
            if ($property->getId() == 2271) {
                $this->assertEquals('/laptopy/sklep:salurion-pl,producent:asus;lenovo.html', $property->getUrlOut());
                $this->assertEquals('/laptopy/sklep:salurion-pl,producent:asus;lenovo,przekatna-ekranu:%s.html', $property->getUrlInTemplate());

                /** @var PropertyValue $value */
                foreach ($property->getEntities() as $value) {
                    $this->assertTrue(in_array($value->getParam(), array('16-9', '4-3')));
                }
            }
        }
    }

    public function testPropertiesConverterWithoutCallbacksWithRanges()
    {
        $productsConverter = new ProductsConverter();
        /** @var Products $products */
        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-filters'));

        $propertiesConverter = new PropertiesConverter();
        $properties = $propertiesConverter->convert($products, array());

        $this->assertEquals(count($products->getProperties()), count($properties));

        foreach ($properties as $property) {
            $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract', $property);
            $this->assertFalse($property->getIsActive());
            if ($property->getId() == 669) {
                /** @var PropertyRange $value */
                foreach ($property->getEntities() as $value) {
                    $this->assertEquals('180.00;200.00;220.00;230.00;250.00', $value->getParam());
                }
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
     * @return stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}
 