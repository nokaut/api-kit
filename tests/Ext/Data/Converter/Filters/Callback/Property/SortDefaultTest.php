<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyRanges;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyValues;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PropertyRange;
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

        $propertyValue = new PropertyValue();
        $propertyValue->setName('csdfsd');
        $propertyValue->setTotal(4);
        $propertyValues[] = $propertyValue;

        $property = new PropertyValues($propertyValues);

        $callback = new SortDefault();
        $callback($property, $products);

        $entities = $property->getEntities();

        $this->assertEquals('Asdfsdf', $entities[0]->getName());
        $this->assertEquals('Bsdfsfd', $entities[1]->getName());
        $this->assertEquals('csdfsd', $entities[2]->getName());
        $this->assertEquals('csdfsdf', $entities[3]->getName());
        $this->assertEquals('Dsdfsdf', $entities[4]->getName());
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
        $propertyValue->setName('23');
        $propertyValue->setTotal(5);
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

        $this->assertEquals(5, $entities[0]->getTotal());
        $this->assertEquals(4, $entities[1]->getTotal());
        $this->assertEquals(3, $entities[2]->getTotal());
        $this->assertEquals(2, $entities[3]->getTotal());
        $this->assertEquals(1, $entities[4]->getTotal());
        $this->assertEquals(1, $property->getLast()->getTotal());
    }

    public function testNaturalRanges()
    {
        $products = new Products(array());

        $propertyValues = array();

        $propertyValue = new PropertyRange();
        $propertyValue->setName('qwe - wer');
        $propertyValue->setTotal(1);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyRange();
        $propertyValue->setName('asd - sdf');
        $propertyValue->setTotal(2);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyRange();
        $propertyValue->setName('as - sdf');
        $propertyValue->setTotal(2);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyRange();
        $propertyValue->setName('zxc - xcv');
        $propertyValue->setTotal(3);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyRange();
        $propertyValue->setName('dfg - fgh');
        $propertyValue->setTotal(4);
        $propertyValues[] = $propertyValue;

        $property = new PropertyRanges($propertyValues);

        $callback = new SortDefault();
        $callback($property, $products);

        $entities = $property->getEntities();

        $this->assertEquals('as - sdf', $entities[0]->getName());
        $this->assertEquals('asd - sdf', $entities[1]->getName());
        $this->assertEquals('dfg - fgh', $entities[2]->getName());
        $this->assertEquals('qwe - wer', $entities[3]->getName());
        $this->assertEquals('zxc - xcv', $entities[4]->getName());
        $this->assertEquals('zxc - xcv', $property->getLast()->getName());
    }

    public function testNumericRanges()
    {
        $products = new Products(array());

        $propertyValues = array();

        $propertyValue = new PropertyRange();
        $propertyValue->setName('456 - 567');
        $propertyValue->setTotal(1);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyRange();
        $propertyValue->setName('234 - 345');
        $propertyValue->setTotal(2);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyRange();
        $propertyValue->setName('23 - 345');
        $propertyValue->setTotal(2);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyRange();
        $propertyValue->setName('345 - 456');
        $propertyValue->setTotal(3);
        $propertyValues[] = $propertyValue;

        $propertyValue = new PropertyRange();
        $propertyValue->setName('123 - 234');
        $propertyValue->setTotal(4);
        $propertyValues[] = $propertyValue;

        $property = new PropertyRanges($propertyValues);

        $callback = new SortDefault();
        $callback($property, $products);

        $entities = $property->getEntities();

        $this->assertEquals('23 - 345', $entities[0]->getName());
        $this->assertEquals('123 - 234', $entities[1]->getName());
        $this->assertEquals('234 - 345', $entities[2]->getName());
        $this->assertEquals('345 - 456', $entities[3]->getName());
        $this->assertEquals('456 - 567', $entities[4]->getName());
        $this->assertEquals('456 - 567', $property->getLast()->getName());
    }
}