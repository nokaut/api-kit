<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyValues;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\PropertiesConverter;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\FilterAbstract;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PropertyValue;

class SetIsNofollowTest extends \PHPUnit_Framework_TestCase
{
    public function testPropertyNotSelected()
    {
        $products = new Products(array());
        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(10);
        $propertyValue->setIsFilter(false);
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SetIsNofollow();
        $callback($property, $products);

        foreach ($property as $value) {
            /** @var FilterAbstract $value */
            $this->assertFalse($value->getIsNofollow());
        }
    }

    public function testPropertySingleValueSelected()
    {
        $products = new Products(array());
        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(10);
        $propertyValue->setIsFilter(false);
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(10);
        $propertyValue->setName('namexyz');
        $propertyValue->setIsFilter(true);
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SetIsNofollow();
        $callback($property, $products);

        foreach ($property as $value) {
            /** @var FilterAbstract $value */
            if ($value->getName() == 'namexyz') {
                $this->assertFalse($value->getIsNofollow());
            } else {
                $this->assertTrue($value->getIsNofollow());
            }
        }
    }

    public function testPropertyTwoValuesSelected()
    {
        $products = new Products(array());
        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(10);
        $propertyValue->setIsFilter(false);
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(10);
        $propertyValue->setName('namexyz1');
        $propertyValue->setIsFilter(true);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(10);
        $propertyValue->setName('namexyz2');
        $propertyValue->setIsFilter(true);
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SetIsNofollow();
        $callback($property, $products);

        foreach ($property as $value) {
            /** @var FilterAbstract $value */
            if (in_array($value->getName(), array('namexyz1', 'namexyz2'))) {
                $this->assertFalse($value->getIsNofollow());
            } else {
                $this->assertTrue($value->getIsNofollow());
            }
        }
    }

    public function testPropertyThreeValuesSelected()
    {
        $products = new Products(array());
        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(10);
        $propertyValue->setIsFilter(false);
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(10);
        $propertyValue->setName('namexyz1');
        $propertyValue->setIsFilter(true);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(10);
        $propertyValue->setName('namexyz2');
        $propertyValue->setIsFilter(true);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(10);
        $propertyValue->setName('namexyz3');
        $propertyValue->setIsFilter(true);
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SetIsNofollow();
        $callback($property, $products);

        foreach ($property as $value) {
            $this->assertTrue($value->getIsNofollow());
        }
    }

    public function testOtherPropertiesRangeNoFollow()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-filters'));

        $propertiesConverter = new PropertiesConverter();
        $properties = $propertiesConverter->convert($products, array(
            new SetIsNofollow()
        ));

        /** @var PropertyAbstract $property */
        foreach ($properties as $property) {
            foreach ($property as $value) {
                $this->assertTrue($value->getIsNofollow());
            }
        }
    }

    public function testOtherPropertiesValuesNoFollow()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-filters-without-range'));

        $propertiesConverter = new PropertiesConverter();
        $properties = $propertiesConverter->convert($products, array(
            new SetIsNofollow()
        ));

        /** @var PropertyAbstract $property */
        foreach ($properties as $property) {
            if ($property->getId() == 382) {
                /**
                 * {
                 * id: 382,
                 * name: "Złącze USB",
                 * values: [
                 * {
                 * name: "1",
                 * total: 104,
                 * url: "/telewizory-led/zlacze-usb:3.html",
                 * is_filter: true
                 * },
                 * {
                 * name: "3",
                 * total: 74,
                 * url: "/telewizory-led/zlacze-usb:1.html",
                 * is_filter: true
                 * },
                 * {
                 * name: "2",
                 * total: 49,
                 * url: "/telewizory-led/zlacze-usb:1;3;2.html"
                 * }
                 * ]
                 * },
                 */
                /** @var PropertyAbstract $property */
                foreach ($property as $value) {
                    if ($value->getIsFilter()) {
                        $this->assertFalse($value->getIsNofollow());
                    } else {
                        $this->assertTrue($value->getIsNofollow());
                    }
                }
            } else {
                foreach ($property as $value) {
                    $this->assertTrue($value->getIsNofollow());
                }
            }
        }
    }

    /**
     * @param $name
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}