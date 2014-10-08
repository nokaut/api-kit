<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyValues;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PropertyValue;

class SortDefaultTest extends \PHPUnit_Framework_TestCase
{
    public function testNaturalValues()
    {
        $products = new Products(array());

        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setName('Bsdfsfd');
        $propertyValue->setTotal(1);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setName('Asdfsdf');
        $propertyValue->setTotal(2);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setName('Dsdfsdf');
        $propertyValue->setTotal(3);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setName('csdfsdf');
        $propertyValue->setTotal(4);
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SortDefault();
        $callback($property, $products);

        $entities = $property->getEntities();

        $this->assertEquals('Asdfsdf', $entities[0]->getName());
        $this->assertEquals('Bsdfsfd', $entities[1]->getName());
        $this->assertEquals('csdfsdf', $entities[2]->getName());
        $this->assertEquals('Dsdfsdf', $entities[3]->getName());
        $this->assertEquals('Dsdfsdf', $property->getLast()->getName());
    }

    public function testNumericValues()
    {
        $products = new Products(array());

        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setName('123');
        $propertyValue->setTotal(1);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setName('234');
        $propertyValue->setTotal(2);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setName('345');
        $propertyValue->setTotal(3);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setName('456');
        $propertyValue->setTotal(4);
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SortDefault();
        $callback($property, $products);

        $entities = $property->getEntities();

        $this->assertEquals(4, $entities[0]->getTotal());
        $this->assertEquals(3, $entities[1]->getTotal());
        $this->assertEquals(2, $entities[2]->getTotal());
        $this->assertEquals(1, $entities[3]->getTotal());
        $this->assertEquals(1, $property->getLast()->getTotal());
    }

    public function testNaturalRanges()
    {
        $products = new Products(array());

        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setName('qwe - wer');
        $propertyValue->setTotal(1);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setName('asd - sdf');
        $propertyValue->setTotal(2);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setName('zxc - xcv');
        $propertyValue->setTotal(3);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setName('dfg - fgh');
        $propertyValue->setTotal(4);
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SortDefault();
        $callback($property, $products);

        $entities = $property->getEntities();

        $this->assertEquals('asd - sdf', $entities[0]->getName());
        $this->assertEquals('dfg - fgh', $entities[1]->getName());
        $this->assertEquals('qwe - wer', $entities[2]->getName());
        $this->assertEquals('zxc - xcv', $entities[3]->getName());
        $this->assertEquals('zxc - xcv', $property->getLast()->getName());
    }

    public function testNumericRanges()
    {
        $products = new Products(array());

        $propertyValues = array();

        $propertyValue = new PropertyValue();
        $propertyValue->setName('123 - 234');
        $propertyValue->setTotal(1);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setName('234 - 345');
        $propertyValue->setTotal(2);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setName('345 - 456');
        $propertyValue->setTotal(3);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyValue();
        $propertyValue->setName('456 - 567');
        $propertyValue->setTotal(4);
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SortDefault();
        $callback($property, $products);

        $entities = $property->getEntities();

        $this->assertEquals(4, $entities[0]->getTotal());
        $this->assertEquals(3, $entities[1]->getTotal());
        $this->assertEquals(2, $entities[2]->getTotal());
        $this->assertEquals(1, $entities[3]->getTotal());
        $this->assertEquals(1, $property->getLast()->getTotal());
    }
}