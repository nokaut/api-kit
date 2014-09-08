<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.06.2014
 * Time: 11:03
 */

namespace Nokaut\ApiKit\Collection\Sort;


use Nokaut\ApiKit\Collection\Categories;
use Nokaut\ApiKit\Entity\Category;
use PHPUnit_Framework_TestCase;

class CategoriesSortTest extends PHPUnit_Framework_TestCase
{

    public function testSortByTitle()
    {
        /** @var Categories $categoriesCollection */
        $categoriesCollection = $this->getCategoriesCollection();

        CategoriesSort::sortByTitle($categoriesCollection);

        $this->assertEquals("Aparaty", $categoriesCollection->getItem(0)->getTitle());
        $this->assertEquals("Rowery", $categoriesCollection->getItem(1)->getTitle());
        $this->assertEquals("Zioła", $categoriesCollection->getItem(2)->getTitle());
    }

    public function testSortChildrenByTitle()
    {
        /** @var Categories $categoriesCollection */
        $categoriesCollection = $this->getCategoriesCollection();

        CategoriesSort::sortChildrenByTitle($categoriesCollection);

        $childrenCategory1 = $categoriesCollection->getItem(0)->getChildren();
        $this->assertEquals("Aromaty", $childrenCategory1->getItem(0)->getTitle());
        $this->assertEquals("Fotografia", $childrenCategory1->getItem(1)->getTitle());
        $this->assertEquals("Złom", $childrenCategory1->getItem(2)->getTitle());
    }

    public function testSortByPopularity()
    {
        /** @var Categories $categoriesCollection */
        $categoriesCollection = $this->getCategoriesCollection();

        CategoriesSort::sortByPopularity($categoriesCollection, SORT_DESC);

        $this->assertEquals(53, $categoriesCollection->getItem(0)->getPopularity());
        $this->assertEquals(34, $categoriesCollection->getItem(1)->getPopularity());
        $this->assertEquals(23, $categoriesCollection->getItem(2)->getPopularity());
    }

    private function getCategoriesCollection()
    {
        $collection = array();

        $category1 = new Category();
        $category1->setTitle("Rowery");
        $category1->setPopularity(23);
        $category1->setChildren($this->getChildrenCollection());
        $collection[] = $category1;

        $category2 = new Category();
        $category2->setTitle("Aparaty");
        $category2->setPopularity(53);
        $collection[] = $category2;

        $category3 = new Category();
        $category3->setTitle("Zioła");
        $category3->setPopularity(34);
        $collection[] = $category3;

        return new Categories($collection);
    }

    private function getChildrenCollection()
    {
        $collection = array();

        $category1 = new Category();
        $category1->setTitle("Fotografia");
        $category1->setPopularity(53);
        $collection[] = $category1;

        $category2 = new Category();
        $category2->setTitle("Aromaty");
        $category2->setPopularity(53);
        $collection[] = $category2;

        $category3 = new Category();
        $category3->setTitle("Złom");
        $category3->setPopularity(34);
        $collection[] = $category3;

        return new Categories($collection);
    }
} 