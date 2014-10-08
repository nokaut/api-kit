<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;

class SetIsPopularTest extends \PHPUnit_Framework_TestCase
{
    public function testIsPopularWithEmptyProductsTotal()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(0);
        $products->setMetadata($metadata);

        $shops = array();

        $shop = new Shop();
        $shop->setTotal(5);
        $shops[] = $shop;

        $shopsCollection = new Shops($shops);

        $callback = new SetIsPopular();
        $callback($shopsCollection, $products);

        $entities = $shopsCollection->getEntities();
        $this->assertFalse($entities[0]->getIsPopular());
    }

    public function testIsPopularLowTotal()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);

        $shops = array();

        $shop = new Shop();
        $shop->setTotal(2);
        $shops[] = $shop;

        $shopsCollection = new Shops($shops);

        $callback = new SetIsPopular();
        $callback($shopsCollection, $products);

        $entities = $shopsCollection->getEntities();
        $this->assertFalse($entities[0]->getIsPopular());
    }

    public function testIsPopular()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);

        $shops = array();

        $shop = new Shop();
        $shop->setTotal(3);
        $shops[] = $shop;

        $shopsCollection = new Shops($shops);

        $callback = new SetIsPopular();
        $callback($shopsCollection, $products);

        $entities = $shopsCollection->getEntities();
        $this->assertTrue($entities[0]->getIsPopular());

        /***/
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(100);
        $products->setMetadata($metadata);

        $shops = array();

        $shop = new Shop();
        $shop->setTotal(11); // > 10%
        $shops[] = $shop;

        $shopsCollection = new Shops($shops);

        $callback = new SetIsPopular();
        $callback($shopsCollection, $products);

        $entities = $shopsCollection->getEntities();
        $this->assertTrue($entities[0]->getIsPopular());
    }

    public function testIsNotPopular()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(100);
        $products->setMetadata($metadata);

        $shops = array();

        $shop = new Shop();
        $shop->setTotal(10);
        $shops[] = $shop;

        $shopsCollection = new Shops($shops);

        $callback = new SetIsPopular();
        $callback($shopsCollection, $products);

        $entities = $shopsCollection->getEntities();
        $this->assertFalse($entities[0]->getIsPopular());

        /***/
        $shops = array();

        $shop = new Shop();
        $shop->setTotal(9);
        $shops[] = $shop;

        $shopsCollection = new Shops($shops);

        $callback = new SetIsPopular();
        $callback($shopsCollection, $products);

        $entities = $shopsCollection->getEntities();
        $this->assertFalse($entities[0]->getIsPopular());
    }
}
