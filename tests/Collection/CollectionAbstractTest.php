<?php

namespace Nokaut\ApiKit\Collection;

use Nokaut\ApiKit\Entity\Category;
use PHPUnit\Framework\TestCase;


class CollectionAbstractTest extends TestCase
{
    public function testSetEntities()
    {
        $category1 = new Category();
        $category1->setId(20);
        $category2 = new Category();
        $category2->setId(30);

        $categoryEntities = array();
        $categoryEntities[] = $category1;
        $categoryEntities[] = $category2;

        $categories = new Categories($categoryEntities);
        $this->assertEquals(array(0, 1), array_keys($categories->getEntities()));
        $this->assertEquals(30, $categories->getLast()->getId());
        $categories->setEntities($categoryEntities);
        $this->assertEquals(array(0, 1), array_keys($categories->getEntities()));
        $this->assertEquals(30, $categories->getLast()->getId());

        $categoryEntities = array();
        $categoryEntities[5] = $category1;
        $categoryEntities['12'] = $category2;

        $categories = new Categories($categoryEntities);
        $this->assertEquals(array(0, 1), array_keys($categories->getEntities()));
        $this->assertEquals(30, $categories->getLast()->getId());
        $categories->setEntities($categoryEntities);
        $this->assertEquals(array(0, 1), array_keys($categories->getEntities()));
        $this->assertEquals(30, $categories->getLast()->getId());
    }

    public function testClone()
    {
        $category1 = new Category();
        $category1->setId(20);
        $category2 = new Category();
        $category2->setId(30);

        $categoryEntities = array();
        $categoryEntities[] = $category1;
        $categoryEntities[] = $category2;

        $categories = new Categories($categoryEntities);
        $categoriesClone = clone $categories;

        $category1->setId(220);

        $this->assertNotEquals(spl_object_hash($categories->getItem(0)), spl_object_hash($categoriesClone->getItem(0)));
        $this->assertNotEquals($categories->getItem(0), $categoriesClone->getItem(0));
    }
}