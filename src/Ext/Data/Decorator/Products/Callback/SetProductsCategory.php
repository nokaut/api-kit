<?php


namespace Nokaut\ApiKit\Ext\Data\Decorator\Products\Callback;


use Nokaut\ApiKit\Collection\Categories;
use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Category;
use Nokaut\ApiKit\Entity\Product;

class SetProductsCategory implements CallbackInterface
{
    /**
     * @var Category[]
     */
    private $categoriesById = array();

    /**
     * @param Categories $categories
     */
    function __construct(Categories $categories)
    {
        $this->setCategories($categories);
    }

    public function __invoke(Products $products)
    {
        /** @var $product Product */
        foreach ($products as $product) {
            $category = $this->getCategory($product->getCategoryId());
            if ($category) {
                $product->setCategory($category);
            }
        }
    }

    /**
     * @param Categories $categories
     */
    private function setCategories(Categories $categories)
    {
        /** @var $category Category */
        foreach ($categories as $category) {
            $this->categoriesById[$category->getId()] = $category;
        }
    }

    /**
     * @param $categoryId
     * @return Category
     */
    private function getCategory($categoryId)
    {
        if (isset($this->categoriesById[$categoryId])) {
            return $this->categoriesById[$categoryId];
        }
    }
}