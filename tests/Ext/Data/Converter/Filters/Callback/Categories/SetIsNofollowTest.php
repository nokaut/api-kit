<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Category;

class SetIsNofollowTest extends \PHPUnit_Framework_TestCase
{
    public function testFollow()
    {
        $products = new Products(array());
        $metadata = new ProductsMetadata();
        $metadata->setTotal(10);
        $products->setMetadata($metadata);

        $categories = array();

        $category = new Category();
        $category->setTotal(2);
        $category->setIsFilter(false);
        $categories[] = $category;
        $categories[] = $category;
        $categories[] = $category;

        $categoriesCollection = new Categories($categories);

        $callback = new SetIsNofollow();
        $callback($categoriesCollection, $products);

        foreach ($categoriesCollection as $category) {
            /** @var Category $category */
            $this->assertFalse($category->getIsNofollow());
        }

        /***/
        $categories = array();

        $category = new Category();
        $category->setTotal(2);
        $category->setIsFilter(true);
        $categories[] = $category;
        $categories[] = $category;
        $categories[] = $category;

        $categoriesCollection = new Categories($categories);

        $callback = new SetIsNofollow();
        $callback($categoriesCollection, $products);

        foreach ($categoriesCollection as $category) {
            /** @var Category $category */
            $this->assertFalse($category->getIsNofollow());
        }
    }
}