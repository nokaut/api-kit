<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Category;

class SortByTotalTest extends \PHPUnit_Framework_TestCase
{
    public function testSort()
    {
        $products = new Products(array());

        $categories = array();

        $category = new Category();
        $category->setTotal(5);
        $categories[] = $category;

        $category = new Category();
        $category->setTotal(4);
        $categories[] = $category;

        $category = new Category();
        $category->setTotal(10);
        $categories[] = $category;

        $category = new Category();
        $category->setTotal(2);
        $categories[] = $category;

        $category = new Category();
        $category->setTotal(8);
        $categories[] = $category;

        $categoriesCollection = new Categories($categories);

        $callback = new SortByTotal();
        $callback($categoriesCollection, $products);

        $entities = $categoriesCollection->getEntities();
        $this->assertEquals(10, $entities[0]->getTotal());
        $this->assertEquals(8, $entities[1]->getTotal());
        $this->assertEquals(5, $entities[2]->getTotal());
        $this->assertEquals(4, $entities[3]->getTotal());
        $this->assertEquals(2, $entities[4]->getTotal());
        $this->assertEquals(2, $categoriesCollection->getLast()->getTotal());
    }
}
