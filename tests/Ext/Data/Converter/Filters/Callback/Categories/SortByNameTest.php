<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Category;

class SortByNameTest extends \PHPUnit_Framework_TestCase
{
    public function testSort()
    {
        $products = new Products(array());

        $categories = array();

        $category = new Category();
        $category->setName('qwe');
        $categories[] = $category;

        $category = new Category();
        $category->setName('azd');
        $categories[] = $category;

        $category = new Category();
        $category->setName('zzc');
        $categories[] = $category;

        $category = new Category();
        $category->setName('Zsd');
        $categories[] = $category;

        $category = new Category();
        $category->setName('Asd');
        $categories[] = $category;

        $categoriesCollection = new Categories($categories);

        $callback = new SortByName();
        $callback($categoriesCollection, $products);

        $entities = $categoriesCollection->getEntities();
        $this->assertEquals('Asd', $entities[0]->getName());
        $this->assertEquals('azd', $entities[1]->getName());
        $this->assertEquals('qwe', $entities[2]->getName());
        $this->assertEquals('Zsd', $entities[3]->getName());
        $this->assertEquals('zzc', $entities[4]->getName());
        $this->assertEquals('zzc', $categoriesCollection->getLast()->getName());
    }
}
 