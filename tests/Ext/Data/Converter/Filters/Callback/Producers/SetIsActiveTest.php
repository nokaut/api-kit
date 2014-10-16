<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;

class SetIsActiveTest extends \PHPUnit_Framework_TestCase
{
    public function testNotIsActive()
    {
        $products = new Products(array());

        $producers = array();

        $producer = new Producer();
        $producer->setIsFilter(false);
        $producers[] = $producer;
        $producers[] = $producer;
        $producers[] = $producer;

        $property = new Producers($producers);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertFalse($property->getIsActive());
    }

    public function testIsActive()
    {
        $products = new Products(array());

        $producers = array();
        $producer = new Producer();
        $producer->setIsFilter(false);
        $producers[] = $producer;
        $producers[] = $producer;
        $producer = new Producer();
        $producer->setIsFilter(true);
        $producers[] = $producer;

        $property = new Producers($producers);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertTrue($property->getIsActive());

        /***/
        $producers = array();
        $producer = new Producer();
        $producer->setIsFilter(true);
        $producers[] = $producer;
        $producers[] = $producer;
        $producers[] = $producer;

        $property = new Producers($producers);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertFalse($property->getIsActive());

        /***/
        $producers = array();
        $producer = new Producer();
        $producer->setIsFilter(true);
        $producers[] = $producer;
        $producer = new Producer();
        $producer->setIsFilter(false);
        $producers[] = $producer;
        $producers[] = $producer;

        $property = new Producers($producers);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertTrue($property->getIsActive());
    }
}
 