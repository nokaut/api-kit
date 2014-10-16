<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;

class SortByTotalTest extends \PHPUnit_Framework_TestCase
{
    public function testSort()
    {
        $products = new Products(array());

        $producers = array();

        $producer = new Producer();
        $producer->setTotal(5);
        $producers[] = $producer;

        $producer = new Producer();
        $producer->setTotal(4);
        $producers[] = $producer;

        $producer = new Producer();
        $producer->setTotal(10);
        $producers[] = $producer;

        $producer = new Producer();
        $producer->setTotal(2);
        $producers[] = $producer;

        $producer = new Producer();
        $producer->setTotal(8);
        $producers[] = $producer;

        $producersCollection = new Producers($producers);

        $callback = new SortByTotal();
        $callback($producersCollection, $products);

        $entities = $producersCollection->getEntities();
        $this->assertEquals(10, $entities[0]->getTotal());
        $this->assertEquals(8, $entities[1]->getTotal());
        $this->assertEquals(5, $entities[2]->getTotal());
        $this->assertEquals(4, $entities[3]->getTotal());
        $this->assertEquals(2, $entities[4]->getTotal());
        $this->assertEquals(2, $producersCollection->getLast()->getTotal());
    }
}
