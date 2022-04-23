<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 14.10.2014
 * Time: 14:05
 */

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Category;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;
use PHPUnit\Framework\TestCase;

class SetParentCategoryTest extends TestCase
{
    public function testSetParentCategory()
    {
        $categories = new Categories(array());
        $cut = new SetParentCategory($this->prepareCurrentCategory());


        $cut($categories, new Products(array()));

        $parentCategory = $categories->getParentCategory();
        $parentCategoryPath = $this->prepareParentCategoryPath();
        $this->assertNotEmpty($parentCategory);
        $this->assertEquals($parentCategory->getName(), $parentCategoryPath->getTitle());
        $this->assertEquals($parentCategory->getUrl(), $parentCategoryPath->getUrl());
        $this->assertEquals($parentCategory->getIsFilter(), false);
        $this->assertEquals($parentCategory->getIsNofollow(), false);

        $categoriesClone = clone $categories;
        $this->assertNotEquals(spl_object_hash($categories->getParentCategory()), spl_object_hash($categoriesClone->getParentCategory()));
        $this->assertEquals($categories->getParentCategory()->getName(), $categoriesClone->getParentCategory()->getName());
    }

    protected function prepareCurrentCategory()
    {

        $parentCategoryPath = $this->prepareParentCategoryPath();

        $category = new Category();
        $category->setId(2);
        $category->setParentId($parentCategoryPath->getId());
        $category->setTitle('Current Category');

        $pathList = array();

        $path = new Category\Path();
        $path->setTitle("Category 30");
        $path->setId(30);
        $path->setUrl('/category30');
        $pathList[] = $path;

        $pathList[] = $parentCategoryPath;

        $path = new Category\Path();
        $path->setTitle("Current Category");
        $path->setId(2);
        $path->setUrl('/category2');
        $pathList[] = $path;

        $category->setPath($pathList);

        return $category;
    }

    /**
     * @return Category\Path
     */
    protected function prepareParentCategoryPath()
    {
        $path = new Category\Path();
        $path->setTitle("Category 1");
        $path->setId(1);
        $path->setUrl('/category1');
        return $path;
    }
} 