<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property\SetIsActive;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\FilterAbstract;
use PHPUnit\Framework\TestCase;
use stdClass;

class PropertiesConverterTest extends TestCase
{
    public function testCache()
    {
        $productsConverter = new ProductsConverter();
        /** @var Products $products */
        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-filters-without-range'));

        // facets
        $propertiesConverter = new \Nokaut\ApiKit\Ext\Data\Converter\Filters\PropertiesConverter();
        $properties = $propertiesConverter->convert($products, array());
        $this->assertEquals(9, count($properties));
        foreach ($properties as $property) {
            if ($property->getId() == 382) {
                $this->assertEquals(3, count($property));
                break;
            }
        }

        // selected
        $propertiesConverterSelected = new PropertiesConverter();
        $propertiesSelected = $propertiesConverterSelected->convert($products, array());
        $this->assertEquals(1, count($propertiesSelected));
        foreach ($propertiesSelected as $property) {
            if ($property->getId() == 382) {
                $propertySelected382ObjectId = spl_object_hash($property);
                $this->assertEquals(2, count($property));
                break;
            }
        }

        /**
         * nie moga sie zmienic po konwersji selected
         */
        $this->assertEquals(9, count($properties));
        foreach ($properties as $property) {
            if ($property->getId() == 382) {
                $property382ObjectId = spl_object_hash($property);
                $this->assertEquals(3, count($property));
                break;
            }
        }

        $this->assertNotNull($propertySelected382ObjectId);
        $this->assertNotNull($property382ObjectId);
        $this->assertNotEquals($propertySelected382ObjectId, $property382ObjectId);
    }

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
     * @return stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}
 