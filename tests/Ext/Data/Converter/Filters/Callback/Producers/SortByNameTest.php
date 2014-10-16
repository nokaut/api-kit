<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;

class SortByNameTest extends \PHPUnit_Framework_TestCase
{
    public function testSort()
    {
        $products = new Products(array());

        $producers = array();

        $producer = new Producer();
        $producer->setName('qwe');
        $producers[] = $producer;

        $producer = new Producer();
        $producer->setName('azd');
        $producers[] = $producer;

        $producer = new Producer();
        $producer->setName('zzc');
        $producers[] = $producer;

        $producer = new Producer();
        $producer->setName('Zsd');
        $producers[] = $producer;

        $producer = new Producer();
        $producer->setName('Asd');
        $producers[] = $producer;

        $producersCollection = new Producers($producers);

        $callback = new SortByName();
        $callback($producersCollection, $products);

        $entities = $producersCollection->getEntities();
        $this->assertEquals('Asd', $entities[0]->getName());
        $this->assertEquals('azd', $entities[1]->getName());
        $this->assertEquals('qwe', $entities[2]->getName());
        $this->assertEquals('Zsd', $entities[3]->getName());
        $this->assertEquals('zzc', $entities[4]->getName());
        $this->assertEquals('zzc', $producersCollection->getLast()->getName());
    }
}
 