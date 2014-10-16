<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;

class SetIsActiveTest extends \PHPUnit_Framework_TestCase
{
    public function testNotIsActive()
    {
        $products = new Products(array());

        $shops = array();

        $shop = new Shop();
        $shop->setIsFilter(false);
        $shops[] = $shop;
        $shops[] = $shop;
        $shops[] = $shop;

        $property = new Shops($shops);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertFalse($property->getIsActive());
    }

    public function testIsActive()
    {
        $products = new Products(array());

        $shops = array();
        $shop = new Shop();
        $shop->setIsFilter(false);
        $shops[] = $shop;
        $shops[] = $shop;
        $shop = new Shop();
        $shop->setIsFilter(true);
        $shops[] = $shop;

        $property = new Shops($shops);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertTrue($property->getIsActive());

        /***/
        $shops = array();
        $shop = new Shop();
        $shop->setIsFilter(true);
        $shops[] = $shop;
        $shops[] = $shop;
        $shops[] = $shop;

        $property = new Shops($shops);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertFalse($property->getIsActive());

        /***/
        $shops = array();
        $shop = new Shop();
        $shop->setIsFilter(true);
        $shops[] = $shop;
        $shop = new Shop();
        $shop->setIsFilter(false);
        $shops[] = $shop;
        $shops[] = $shop;

        $property = new Shops($shops);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertTrue($property->getIsActive());
    }
}
 