<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;

class SortByNameTest extends \PHPUnit_Framework_TestCase
{
    public function testSort()
    {
        $products = new Products(array());

        $shops = array();

        $shop = new Shop();
        $shop->setName('qwe');
        $shops[] = $shop;

        $shop = new Shop();
        $shop->setName('azd');
        $shops[] = $shop;

        $shop = new Shop();
        $shop->setName('zzc');
        $shops[] = $shop;

        $shop = new Shop();
        $shop->setName('Zsd');
        $shops[] = $shop;

        $shop = new Shop();
        $shop->setName('Asd');
        $shops[] = $shop;

        $shopsCollection = new Shops($shops);

        $callback = new SortByName();
        $callback($shopsCollection, $products);

        $entities = $shopsCollection->getEntities();
        $this->assertEquals('Asd', $entities[0]->getName());
        $this->assertEquals('azd', $entities[1]->getName());
        $this->assertEquals('qwe', $entities[2]->getName());
        $this->assertEquals('Zsd', $entities[3]->getName());
        $this->assertEquals('zzc', $entities[4]->getName());
        $this->assertEquals('zzc', $shopsCollection->getLast()->getName());
    }
}
 