<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;

class SortByTotalTest extends \PHPUnit_Framework_TestCase
{
    public function testSort()
    {
        $products = new Products(array());

        $shops = array();

        $shop = new Shop();
        $shop->setTotal(5);
        $shops[] = $shop;

        $shop = new Shop();
        $shop->setTotal(4);
        $shops[] = $shop;

        $shop = new Shop();
        $shop->setTotal(10);
        $shops[] = $shop;

        $shop = new Shop();
        $shop->setTotal(2);
        $shops[] = $shop;

        $shop = new Shop();
        $shop->setTotal(8);
        $shops[] = $shop;

        $shopsCollection = new Shops($shops);

        $callback = new SortByTotal();
        $callback($shopsCollection, $products);

        $entities = $shopsCollection->getEntities();
        $this->assertEquals(10, $entities[0]->getTotal());
        $this->assertEquals(8, $entities[1]->getTotal());
        $this->assertEquals(5, $entities[2]->getTotal());
        $this->assertEquals(4, $entities[3]->getTotal());
        $this->assertEquals(2, $entities[4]->getTotal());
        $this->assertEquals(2, $shopsCollection->getLast()->getTotal());
    }
}
