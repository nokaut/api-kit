<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;

class SetIsExcludedTest extends \PHPUnit_Framework_TestCase
{
    public function testOnlyOneActiveValueTotalEqualsProductsTotal()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);

        $shops = array();

        $shop = new Shop();
        $shop->setTotal(10);
        $shop->setIsFilter(false);

        $shop = new Shop();
        $shop->setTotal(0);
        $shop->setIsFilter(false);
        $shops[] = $shop;
        $shops[] = $shop;
        $shops[] = $shop;

        $property = new Shops($shops);

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
        $shops = array();

        $shop = new Shop();
        $shop->setTotal(0);
        $shop->setIsFilter(false);
        $shops[] = $shop;
        $shops[] = $shop;
        $shops[] = $shop;

        $property = new Shops($shops);

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
        $shops = array();

        $shop = new Shop();
        $shop->setTotal(1);
        $shop->setIsFilter(true);
        $shops[] = $shop;
        $shops[] = $shop;
        $shops[] = $shop;

        $property = new Shops($shops);

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
        $shops = array();

        $shop = new Shop();
        $shop->setTotal(1);
        $shop->setIsFilter(true);
        $shops[] = $shop;

        $shop = new Shop();
        $shop->setTotal(0);
        $shop->setIsFilter(false);
        $shops[] = $shop;

        $shop = new Shop();
        $shop->setTotal(5);
        $shop->setIsFilter(false);
        $shops[] = $shop;

        $property = new Shops($shops);

        $callback = new SetIsExcluded();
        $callback($property, $products);

        $this->assertFalse($property->getIsExcluded());
    }
}
 