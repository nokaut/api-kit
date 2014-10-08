<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;

class SetIsNofollowTest extends \PHPUnit_Framework_TestCase
{
    public function testFollow()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);

        $producers = array();

        $producer = new Producer();
        $producer->setTotal(2);
        $producer->setIsFilter(false);
        $producers[] = $producer;
        $producers[] = $producer;
        $producers[] = $producer;

        $producersCollection = new Producers($producers);

        $callback = new SetIsNofollow();
        $callback($producersCollection, $products);

        foreach ($producersCollection as $producer) {
            /** @var Producer $producer */
            $this->assertFalse($producer->getIsNofollow());
        }
    }

    public function testNofollow()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);

        /* 1 filtr */
        $producers = array();

        $producer = new Producer();
        $producer->setTotal(2);
        $producer->setIsFilter(false);
        $producers[] = $producer;
        $producers[] = $producer;
        $producer = new Producer();
        $producer->setTotal(2);
        $producer->setIsFilter(true);
        $producers[] = $producer;

        $producersCollection = new Producers($producers);

        $callback = new SetIsNofollow();
        $callback($producersCollection, $products);

        foreach ($producersCollection as $producer) {
            /** @var Producer $producer */
            if ($producer->getIsFilter()) {
                $this->assertFalse($producer->getIsNofollow());
            } else {
                $this->assertTrue($producer->getIsNofollow());
            }
        }

        /* 2 filtry */
        $producers = array();

        $producer = new Producer();
        $producer->setTotal(2);
        $producer->setIsFilter(false);
        $producers[] = $producer;
        $producer = new Producer();
        $producer->setTotal(2);
        $producer->setIsFilter(true);
        $producers[] = $producer;
        $producers[] = $producer;

        $producersCollection = new Producers($producers);

        $callback = new SetIsNofollow();
        $callback($producersCollection, $products);

        foreach ($producersCollection as $producer) {
            /** @var Producer $producer */
            if ($producer->getIsFilter()) {
                $this->assertFalse($producer->getIsNofollow());
            } else {
                $this->assertTrue($producer->getIsNofollow());
            }
        }
    }
}