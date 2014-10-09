<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters;

use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\PriceRanges\SetIsNofollow;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PriceRange;

class PriceRangesConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testPriceRangeConverterWithoutCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        $priceRangesConverter = new PriceRangesConverter();
        $priceRanges = $priceRangesConverter->convert($products);


        $this->assertEquals('Cena', $priceRanges->getName());
        $this->assertEquals('/laptopy/cena:%s~%s.html', $priceRanges->getUrlInTemplate());
        $this->assertEquals('zł', $priceRanges->getUnit());
        $this->assertEquals(4, $priceRanges->count());
        $this->assertEquals(count($products->getPrices()), $priceRanges->count());

        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges', $priceRanges);

        foreach ($priceRanges as $priceRange) {
            /** @var PriceRange $priceRange */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\PriceRange', $priceRange);
            $this->assertFalse($priceRange->getIsNofollow());
            $this->assertFalse($priceRange->getIsFilter());
            $this->assertGreaterThan(0, $priceRange->getTotal());
            $this->assertGreaterThan(0, $priceRange->getMin());
            $this->assertGreaterThan(0, $priceRange->getMax());
            $this->assertGreaterThan($priceRange->getMin(), $priceRange->getMax());
            $this->assertEquals(
                sprintf("%s - %s", number_format($priceRange->getMin(), 2, ',', ''), number_format($priceRange->getMax(), 2, ',', '')),
                $priceRange->getName()
            );
        }
    }

    public function testPriceRangeConverterWithCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        $priceRangesConverter = new PriceRangesConverter();
        $priceRanges = $priceRangesConverter->convert($products, array(new SetIsNofollow()));

        $this->assertEquals('Cena', $priceRanges->getName());
        $this->assertEquals('/laptopy/cena:%s~%s.html', $priceRanges->getUrlInTemplate());
        $this->assertEquals('zł', $priceRanges->getUnit());
        $this->assertEquals(4, $priceRanges->count());
        $this->assertEquals(count($products->getPrices()), $priceRanges->count());

        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges', $priceRanges);

        foreach ($priceRanges as $priceRange) {
            /** @var PriceRange $priceRange */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\PriceRange', $priceRange);
            $this->assertTrue($priceRange->getIsNofollow());
            $this->assertFalse($priceRange->getIsFilter());
            $this->assertGreaterThan(0, $priceRange->getTotal());
            $this->assertGreaterThan(0, $priceRange->getMin());
            $this->assertGreaterThan(0, $priceRange->getMax());
            $this->assertGreaterThan($priceRange->getMin(), $priceRange->getMax());
            $this->assertEquals(
                sprintf("%s - %s", number_format($priceRange->getMin(), 2, ',', ''), number_format($priceRange->getMax(), 2, ',', '')),
                $priceRange->getName()
            );
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
 