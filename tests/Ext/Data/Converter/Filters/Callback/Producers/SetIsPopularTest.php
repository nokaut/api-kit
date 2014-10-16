<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;

class SetIsPopularTest extends \PHPUnit_Framework_TestCase
{
    public function testIsPopularWithEmptyProductsTotal()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(0);
        $products->setMetadata($metadata);

        $producers = array();

        $producer = new Producer();
        $producer->setTotal(5);
        $producers[] = $producer;

        $producersCollection = new Producers($producers);

        $callback = new SetIsPopular();
        $callback($producersCollection, $products);

        $entities = $producersCollection->getEntities();
        $this->assertFalse($entities[0]->getIsPopular());
    }

    public function testIsPopularLowTotal()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(1000);
        $products->setMetadata($metadata);

        $producers = array();

        $producer = new Producer();
        $producer->setTotal(10); //1%
        $producers[] = $producer;

        $producersCollection = new Producers($producers);

        $callback = new SetIsPopular();
        $callback($producersCollection, $products);

        $entities = $producersCollection->getEntities();
        $this->assertFalse($entities[0]->getIsPopular());
    }

    public function testIsPopular()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);

        $producers = array();

        $producer = new Producer();
        $producer->setTotal(3);
        $producers[] = $producer;

        $producersCollection = new Producers($producers);

        $callback = new SetIsPopular();
        $callback($producersCollection, $products);

        $entities = $producersCollection->getEntities();
        $this->assertTrue($entities[0]->getIsPopular());

        /***/
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(1000);
        $products->setMetadata($metadata);

        $producers = array();

        $producer = new Producer();
        $producer->setTotal(11); // > 1%
        $producers[] = $producer;

        $producersCollection = new Producers($producers);

        $callback = new SetIsPopular();
        $callback($producersCollection, $products);

        $entities = $producersCollection->getEntities();
        $this->assertTrue($entities[0]->getIsPopular());
    }

    public function testIsNotPopular()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(1000);
        $products->setMetadata($metadata);

        $producers = array();

        $producer = new Producer();
        $producer->setTotal(10);
        $producers[] = $producer;

        $producersCollection = new Producers($producers);

        $callback = new SetIsPopular();
        $callback($producersCollection, $products);

        $entities = $producersCollection->getEntities();
        $this->assertFalse($entities[0]->getIsPopular());

        /***/
        $producers = array();

        $producer = new Producer();
        $producer->setTotal(9);
        $producers[] = $producer;

        $producersCollection = new Producers($producers);

        $callback = new SetIsPopular();
        $callback($producersCollection, $products);

        $entities = $producersCollection->getEntities();
        $this->assertFalse($entities[0]->getIsPopular());
    }
}
