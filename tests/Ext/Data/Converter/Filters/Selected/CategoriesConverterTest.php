<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories\SortByName;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Category;
use PHPUnit\Framework\TestCase;
use stdClass;

class CategoriesConverterTest extends TestCase
{
    public function testCache()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('search-telewizor'));

        // facets
        $categoriesConverter = new \Nokaut\ApiKit\Ext\Data\Converter\Filters\CategoriesConverter();
        $categories = $categoriesConverter->convert($products);
        $this->assertEquals(4, $categories->count());

        // selected
        $categoriesConverter = new CategoriesConverter();
        $categoriesSelected = $categoriesConverter->convert($products);

        // nie moga sie zmienic po konwersji selected
        $this->assertEquals(4, $categories->count());
        $this->assertEquals(0, $categoriesSelected->count());
    }

    public function testCategoryConverterWithoutCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        $categoriesConverter = new CategoriesConverter();
        $categories = $categoriesConverter->convert($products);

        $this->assertEquals('Kategoria', $categories->getName());
        $this->assertEquals(1, $categories->count());
        $this->assertEquals(count($products->getCategories()), $categories->count());

        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories', $categories);

        foreach ($categories as $category) {
            /** @var Category $category */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\Category', $category);
            $this->assertGreaterThan(0, $category->getId());
        }
    }

    public function testCategoryConverterWithCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        $categoriesConverter = new CategoriesConverter();
        $categories = $categoriesConverter->convert($products, array(new SortByName()));

        $this->assertEquals('Kategoria', $categories->getName());
        $this->assertEquals(1, $categories->count());
        $this->assertEquals(count($products->getCategories()), $categories->count());

        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories', $categories);

        foreach ($categories as $category) {
            /** @var Category $category */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\Category', $category);
            $this->assertGreaterThan(0, $category->getId());
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
