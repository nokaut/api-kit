<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Category;

class SetIsActiveTest extends \PHPUnit_Framework_TestCase
{
    public function testNotIsActive()
    {
        $products = new Products(array());

        $categories = array();

        $category = new Category();
        $category->setIsFilter(false);
        $categories[] = $category;
        $categories[] = $category;
        $categories[] = $category;

        $property = new Categories($categories);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertFalse($property->getIsActive());
    }

    public function testIsActive()
    {
        $products = new Products(array());

        $categories = array();
        $category = new Category();
        $category->setIsFilter(false);
        $categories[] = $category;
        $categories[] = $category;
        $category = new Category();
        $category->setIsFilter(true);
        $categories[] = $category;

        $property = new Categories($categories);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertTrue($property->getIsActive());

        /***/
        $categories = array();
        $category = new Category();
        $category->setIsFilter(true);
        $categories[] = $category;
        $categories[] = $category;
        $categories[] = $category;

        $property = new Categories($categories);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertFalse($property->getIsActive());

        /***/
        $categories = array();
        $category = new Category();
        $category->setIsFilter(true);
        $categories[] = $category;
        $category = new Category();
        $category->setIsFilter(false);
        $categories[] = $category;
        $categories[] = $category;

        $property = new Categories($categories);

        $callback = new SetIsActive();
        $callback($property, $products);

        $this->assertTrue($property->getIsActive());
    }
}
 