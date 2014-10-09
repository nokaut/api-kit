<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters;

use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Shops\SetIsPopular;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop;

class ShopsConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testShopConverterWithoutCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        $shopsConverter = new ShopsConverter();
        $shops = $shopsConverter->convert($products);

        $this->assertEquals('Sklep', $shops->getName());
        $this->assertEquals(54, $shops->count());
        $this->assertEquals(count($products->getShops()), $shops->count());

        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops', $shops);

        foreach ($shops as $shop) {
            /** @var Shop $shop */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop', $shop);
            $this->assertFalse($shop->getIsPopular());
            $this->assertGreaterThan(0, $shop->getId());
        }
    }

    public function testShopConverterWithCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        $shopsConverter = new ShopsConverter();
        $shops = $shopsConverter->convert($products, array(new SetIsPopular()));

        $this->assertEquals('Sklep', $shops->getName());
        $this->assertEquals(54, $shops->count());
        $this->assertEquals(count($products->getShops()), $shops->count());

        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\Shops', $shops);

        foreach ($shops as $shop) {
            /** @var Shop $shop */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\Shop', $shop);
            $this->assertGreaterThan(0, $shop->getId());

            if (in_array($shop->getName(), array('Karen.pl', 'SWIAT-LAPTOPOW.PL', 'Komputronik.pl', 'Agito.pl',
                'Morele.net sp. z o.o.', 'kuzniewski.pl - Notebooki', 'Salurion', 'X-KOM.PL', 'Satysfakcja'))
            ) {
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
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}
 