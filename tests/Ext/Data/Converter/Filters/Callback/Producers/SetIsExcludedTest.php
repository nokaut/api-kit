<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Producers;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;

class SetIsExcludedTest extends \PHPUnit_Framework_TestCase
{
    public function testOnlyOneActiveValueTotalEqualsProductsTotal()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);

        $producers = array();

        $producer = new Producer();
        $producer->setTotal(10);
        $producer->setIsFilter(false);

        $producer = new Producer();
        $producer->setTotal(0);
        $producer->setIsFilter(false);
        $producers[] = $producer;
        $producers[] = $producer;
        $producers[] = $producer;

        $property = new Producers($producers);

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
        $producers = array();

        $producer = new Producer();
        $producer->setTotal(0);
        $producer->setIsFilter(false);
        $producers[] = $producer;
        $producers[] = $producer;
        $producers[] = $producer;

        $property = new Producers($producers);

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
        $producers = array();

        $producer = new Producer();
        $producer->setTotal(1);
        $producer->setIsFilter(true);
        $producers[] = $producer;
        $producers[] = $producer;
        $producers[] = $producer;

        $property = new Producers($producers);

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
        $producers = array();

        $producer = new Producer();
        $producer->setTotal(1);
        $producer->setIsFilter(true);
        $producers[] = $producer;

        $producer = new Producer();
        $producer->setTotal(0);
        $producer->setIsFilter(false);
        $producers[] = $producer;

        $producer = new Producer();
        $producer->setTotal(5);
        $producer->setIsFilter(false);
        $producers[] = $producer;

        $property = new Producers($producers);

        $callback = new SetIsExcluded();
        $callback($property, $products);

        $this->assertFalse($property->getIsExcluded());
    }
}
 