<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyValues;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PropertyValue;

class SetIsExcludedTest extends \PHPUnit_Framework_TestCase
{
    public function testOnlyOneActiveValueTotalEqualsProductsTotal()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);

        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(10);
        $propertyValue->setIsFilter(false);

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(0);
        $propertyValue->setIsFilter(false);
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SetIsExcluded();
        $callback($property, $products);

        $this->assertTrue($property->getIsExcluded());
    }

    public function testAllEmptyValues()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);
        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(0);
        $propertyValue->setIsFilter(false);
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SetIsExcluded();
        $callback($property, $products);

        $this->assertTrue($property->getIsExcluded());
    }

    public function testAllSelectedValues()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);
        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(1);
        $propertyValue->setIsFilter(true);
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SetIsExcluded();
        $callback($property, $products);

        $this->assertFalse($property->getIsExcluded());
    }

    public function testStandard()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);
        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(1);
        $propertyValue->setIsFilter(true);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(0);
        $propertyValue->setIsFilter(false);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setTotal(5);
        $propertyValue->setIsFilter(false);
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SetIsExcluded();
        $callback($property, $products);

        $this->assertFalse($property->getIsExcluded());
    }
}
 