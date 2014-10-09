<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops\SetIsPopular;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;

class ShopsConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testShopConverterWithoutCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-shop-selected'));

        $shopsConverter = new ShopsConverter();
        $shops = $shopsConverter->convert($products);

        $this->assertEquals(1, $shops->count());
        $this->assertEquals('Sklep', $shops->getName());
        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops', $shops);

        foreach ($shops as $shop) {
            /** @var Shop $shop */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop', $shop);
            $this->assertFalse($shop->getIsPopular());
        }
    }

    public function testShopConverterWithCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-shop-selected'));

        $shopsConverter = new ShopsConverter();
        $shops = $shopsConverter->convert($products, array(new SetIsPopular()));

        $this->assertEquals(1, $shops->count());
        $this->assertEquals('Sklep', $shops->getName());
        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops', $shops);

        foreach ($shops as $shop) {
            /** @var Shop $shop */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop', $shop);

            if (in_array($shop->getName(), array('Mall.pl'))) {
                $this->assertTrue($shop->getIsPopular());
            } else {
                $this->assertFalse($shop->getIsPopular());
            }
        }
    }

    /**
     * @param $name
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}
 