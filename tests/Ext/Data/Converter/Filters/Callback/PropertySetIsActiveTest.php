<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyValues;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PropertyValue;

class PropertySetIsActiveTest extends \PHPUnit_Framework_TestCase
{

    public function testNotIsActive()
    {
        $products = new Products(array());

        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setIsFilter(false);
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new PropertySetIsActive();
        $callback($property, $products);

        $this->assertFalse($property->getIsActive());
    }

    public function testIsActive()
    {
        $products = new Products(array());

        $propertyValues = array();
        $propertyValue = new PropertyValue();
        $propertyValue->setIsFilter(false);
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;
        $propertyValue->setIsFilter(true);
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new PropertySetIsActive();
        $callback($property, $products);

        $this->assertFalse($property->getIsActive());

        /***/
        $propertyValues = array();
        $propertyValue = new PropertyValue();
        $propertyValue->setIsFilter(true);
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new PropertySetIsActive();
        $callback($property, $products);

        $this->assertFalse($property->getIsActive());

        /***/
        $propertyValues = array();
        $propertyValue = new PropertyValue();
        $propertyValue->setIsFilter(true);
        $propertyValues[] = $propertyValue;
        $propertyValue = new PropertyValue();
        $propertyValue->setIsFilter(false);
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new PropertySetIsActive();
        $callback($property, $products);

        $this->assertTrue($property->getIsActive());
    }
}
 