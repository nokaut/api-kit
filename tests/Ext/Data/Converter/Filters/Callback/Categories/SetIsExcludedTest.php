<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Category;

class SetIsExcludedTest extends \PHPUnit_Framework_TestCase
{
    public function testOnlyOneActiveValueTotalEqualsProductsTotal()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);

        $categories = array();

        $category = new Category();
        $category->setTotal(10);
        $category->setIsFilter(false);

        $category = new Category();
        $category->setTotal(0);
        $category->setIsFilter(false);
        $categories[] = $category;
        $categories[] = $category;
        $categories[] = $category;

        $property = new Categories($categories);

        $callback = new SetIsExcluded();
        $callback($property, $products);

        $this->assertTrue($property->getIsExcluded());
    }

    public function testAllEmptyValues()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);
        $categories = array();

        $category = new Category();
        $category->setTotal(0);
        $category->setIsFilter(false);
        $categories[] = $category;
        $categories[] = $category;
        $categories[] = $category;

        $property = new Categories($categories);

        $callback = new SetIsExcluded();
        $callback($property, $products);

        $this->assertTrue($property->getIsExcluded());
    }

    public function testAllSelectedValues()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);
        $categories = array();

        $category = new Category();
        $category->setTotal(1);
        $category->setIsFilter(true);
        $categories[] = $category;
        $categories[] = $category;
        $categories[] = $category;

        $property = new Categories($categories);

        $callback = new SetIsExcluded();
        $callback($property, $products);

        $this->assertFalse($property->getIsExcluded());
    }

    public function testStandard()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);
        $categories = array();

        $category = new Category();
        $category->setTotal(1);
        $category->setIsFilter(true);
        $categories[] = $category;

        $category = new Category();
        $category->setTotal(0);
        $category->setIsFilter(false);
        $categories[] = $category;

        $category = new Category();
        $category->setTotal(5);
        $category->setIsFilter(false);
        $categories[] = $category;

        $property = new Categories($categories);

        $callback = new SetIsExcluded();
        $callback($property, $products);

        $this->assertFalse($property->getIsExcluded());
    }
}
 