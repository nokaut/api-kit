<?php

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters;

use Nokaut\ApiKit\Converter\ProductsConverter;
use Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories\SortByName;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Category;
use PHPUnit\Framework\TestCase;
use stdClass;

class CategoriesConverterTest extends TestCase
{
    public function testCategoryConverterWithoutCallbacks()
    {
        $productsConverter = new ProductsConverter();
        $products = $productsConverter->convert($this->getJsonFixture('laptopy'));

        $categoriesConverter = new CategoriesConverter();
        $categories = $categoriesConverter->convert($products);

        $this->assertEquals(1, $categories->count());
        $this->assertEquals('Kategoria', $categories->getName());
        $this->assertEquals(count($products->getCategories()), $categories->count());
        $this->assertEquals('/sklep:sklep-morele-net;x-kom-pl,producent:lenovo.html', $categories->getUrlOut());
        $this->assertEquals('/%s/sklep:sklep-morele-net;x-kom-pl,producent:lenovo,rozdzielczosc-px:2560-x-1440+px.html', $categories->getUrlInTemplate());

        $this->assertInstanceOf('\Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories', $categories);

        foreach ($categories as $category) {
            /** @var Category $category */
            $this->assertInstanceOf('Nokaut\ApiKit\Ext\Data\Entity\Filter\Category', $category);
            $this->assertGreaterThan(0, $category->getId());
            $this->assertEquals('laptopy', $category->getParam());
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
        return json_decode(file_get_contents(dirname(__DIR__) . '/../../../fixtures/Ext/Data/' . $name . '.json'));
    }
}
 