<?php

namespace Nokaut\ApiKit\Collection;

use Nokaut\ApiKit\Collection;
use Nokaut\ApiKit\Entity\Category;
use PHPUnit_Framework_TestCase;

class CollectionAbstractTest extends PHPUnit_Framework_TestCase
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
}