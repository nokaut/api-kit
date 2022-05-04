<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops\SetIsPopular;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;
use PHPUnit\Framework\TestCase;
use stdClass;

class ShopsConverterTest extends TestCase
{
    public function testCache()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-shop-selected'));

        // facets
        $shopsConverter = new \Nokaut\ApiKit\Ext\Data\Converter\Filters\ShopsConverter();
        $shops = $shopsConverter->convert($products);
        $this->assertEquals(22, $shops->count());

        // selected
        $shopsConverter = new ShopsConverter();
        $shopsSelected = $shopsConverter->convert($products);

        // nie moga sie zmienic po konwersji selected
        $this->assertEquals(22, $shops->count());
        $this->assertEquals(1, $shopsSelected->count());

        // nie moga byc wspoldzielone przez referencje te same obiekty
        $this->assertNotEquals(spl_object_hash($shops->getItem(2)), spl_object_hash($shopsSelected->getItem(0)));
    }

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
     * @return stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}
 