<?php


namespace Nokaut\ApiKit\Ext\Lib;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;

class ProductsAnalyzerTest extends \PHPUnit_Framework_TestCase
{

    public function testFiltersNofollow()
    {
        $productsConverter = new ProductsConverter();

        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));
        $this->assertFalse(ProductsAnalyzer::filtersNofollow($products));

        $products = $productsConverter->convert($this->getJsonFixture('laptopy-nofollow'));
        $this->assertTrue(ProductsAnalyzer::filtersNofollow($products));

        $products = $productsConverter->convert($this->getJsonFixture('laptopy-with-filters'));
        $this->assertFalse(ProductsAnalyzer::filtersNofollow($products));

        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-filters'));
        $this->assertFalse(ProductsAnalyzer::filtersNofollow($products));

        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-filters-without-range'));
        $this->assertFalse(ProductsAnalyzer::filtersNofollow($products));

        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-shop-selected'));
        $this->assertFalse(ProductsAnalyzer::filtersNofollow($products));
    }

    public function testProductsNoindex()
    {
        $productsConverter = new ProductsConverter();

        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));
        $this->assertFalse(ProductsAnalyzer::productsNoindex($products));

        $products = $productsConverter->convert($this->getJsonFixture('laptopy-nofollow'));
        $this->assertTrue(ProductsAnalyzer::productsNoindex($products));

        $products = $productsConverter->convert($this->getJsonFixture('laptopy-with-filters'));
        $this->assertTrue(ProductsAnalyzer::productsNoindex($products));

        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-filters'));
        $this->assertTrue(ProductsAnalyzer::productsNoindex($products));

        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-filters-without-range'));
        $this->assertTrue(ProductsAnalyzer::productsNoindex($products));

        $products = $productsConverter->convert($this->getJsonFixture('telewizory-led-with-shop-selected'));
        $this->assertTrue(ProductsAnalyzer::productsNoindex($products));
    }

    /**
     * @param $name
     * @return \stdClass
     */
    private function getJsonFixture($name)
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/../fixtures/Ext/Data/' . $name . '.json'));
    }
}
 