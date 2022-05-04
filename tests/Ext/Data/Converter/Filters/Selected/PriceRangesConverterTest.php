<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\PriceRange;
use PHPUnit\Framework\TestCase;
use stdClass;

class PriceRangesConverterTest extends TestCase
{
    public function testCache()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        // facets
        $priceRangesConverter = new \Nokaut\ApiKit\Ext\Data\Converter\Filters\PriceRangesConverter();
        $priceRanges = $priceRangesConverter->convert($products);
        $this->assertEquals(4, $priceRanges->count());

        // selected
        $priceRangesConverter = new PriceRangesConverter();
        $priceRangesSelected = $priceRangesConverter->convert($products);

        // nie moga sie zmienic po konwersji selected
        $this->assertEquals(4, $priceRanges->count());
        $this->assertEquals(0, $priceRangesSelected->count());
    }

    public function testPriceRangeConverterWithoutCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        // do testow zmieniamy ustawienie jednego
        $prices = $products->getPrices();
        $prices[0]->setIsFilter(true);
        $products->setPrices($prices);

        // musimy zmienic url, do cache convertera
        $metadata = new ProductsMetadata();
        $metadata->setUrl('asd');
        $products->setMetadata($metadata);

        $priceRangesConverter = new PriceRangesConverter();
        $priceRanges = $priceRangesConverter->convert($products);

        $this->assertEquals(1, $priceRanges->count());
        $this->assertEquals('Cena', $priceRanges->getName());
        $this->assertEquals('/laptopy/cena:%s~%s.html', $priceRanges->getUrlInTemplate());
        $this->assertEquals('zł', $priceRanges->getUnit());
        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\PriceRanges', $priceRanges);

        foreach ($priceRanges as $priceRange) {
            /** @var PriceRange $priceRange */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\PriceRange', $priceRange);
            $this->assertFalse($priceRange->getIsNofollow());
            $this->assertTrue($priceRange->getIsFilter());
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
     * @return stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}