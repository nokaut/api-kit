<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;

class SetIsNofollowTest extends \PHPUnit_Framework_TestCase
{
    public function testFollow()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);

        $shops = array();

        $shop = new Shop();
        $shop->setTotal(2);
        $shop->setIsFilter(false);
        $shops[] = $shop;
        $shops[] = $shop;
        $shops[] = $shop;

        $shopsCollection = new Shops($shops);

        $callback = new SetIsNofollow();
        $callback($shopsCollection, $products);

        foreach ($shopsCollection as $shop) {
            /** @var Shop $shop */
            $this->assertFalse($shop->getIsNofollow());
        }
    }

    public function testNofollow()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);

        /* 1 filtr */
        $shops = array();

        $shop = new Shop();
        $shop->setTotal(2);
        $shop->setIsFilter(false);
        $shops[] = $shop;
        $shops[] = $shop;
        $shop = new Shop();
        $shop->setTotal(2);
        $shop->setIsFilter(true);
        $shops[] = $shop;

        $shopsCollection = new Shops($shops);

        $callback = new SetIsNofollow();
        $callback($shopsCollection, $products);

        foreach ($shopsCollection as $shop) {
            /** @var Shop $shop */
            if ($shop->getIsFilter()) {
                $this->assertFalse($shop->getIsNofollow());
            } else {
                $this->assertTrue($shop->getIsNofollow());
            }
        }

        /* 2 filtry */
        $shops = array();

        $shop = new Shop();
        $shop->setTotal(2);
        $shop->setIsFilter(false);
        $shops[] = $shop;
        $shop = new Shop();
        $shop->setTotal(2);
        $shop->setIsFilter(true);
        $shops[] = $shop;
        $shops[] = $shop;

        $shopsCollection = new Shops($shops);

        $callback = new SetIsNofollow();
        $callback($shopsCollection, $products);

        foreach ($shopsCollection as $shop) {
            /** @var Shop $shop */
            if ($shop->getIsFilter()) {
                $this->assertFalse($shop->getIsNofollow());
            } else {
                $this->assertTrue($shop->getIsNofollow());
            }
        }
    }
}