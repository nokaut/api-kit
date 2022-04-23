<?php


namespace Nokaut\ApiKit\Collection;


use Nokaut\ApiKit\Converter\ProductsConverter;
use PHPUnit\Framework\TestCase;
use stdClass;

class ProductsTest extends TestCase
{
    public function testClone()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        $productsClone = clone $products;

        $this->assertNotEquals(spl_object_hash($products->getItem(0)), spl_object_hash($productsClone->getItem(0)));
        $this->assertNotEquals(spl_object_hash($products->getMetadata()), spl_object_hash($productsClone->getMetadata()));
        $this->assertNotEquals(spl_object_hash($products->getPhrase()), spl_object_hash($productsClone->getPhrase()));
        $this->assertNotEquals(spl_object_hash(current($products->getCategories())), spl_object_hash(current($productsClone->getCategories())));
        $this->assertNotEquals(spl_object_hash(current($products->getPrices())), spl_object_hash(current($productsClone->getPrices())));
        $this->assertNotEquals(spl_object_hash(current($products->getProducers())), spl_object_hash(current($productsClone->getProducers())));
        $this->assertNotEquals(spl_object_hash(current($products->getProperties())), spl_object_hash(current($productsClone->getProperties())));
        $this->assertNotEquals(spl_object_hash(current($products->getShops())), spl_object_hash(current($productsClone->getShops())));

        $this->assertEquals($products->getItem(0)->getId(), $productsClone->getItem(0)->getId());
        $this->assertEquals($products->getMetadata(), $productsClone->getMetadata());
        $this->assertEquals($products->getPhrase(), $productsClone->getPhrase());
        $this->assertEquals(current($products->getCategories())->getId(), current($productsClone->getCategories())->getId());
        $this->assertEquals(current($products->getPrices())->getMin(), current($productsClone->getPrices())->getMin());
        $this->assertEquals(current($products->getProducers())->getId(), current($productsClone->getProducers())->getId());
        $this->assertEquals(current($products->getProperties())->getId(), current($productsClone->getProperties())->getId());
        $this->assertEquals(current($products->getShops())->getId(), current($productsClone->getShops())->getId());
    }

    /**
     * @param $name
     * @return stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/fixtures/Ext/Data/' . $name . '.json'));
    }
}