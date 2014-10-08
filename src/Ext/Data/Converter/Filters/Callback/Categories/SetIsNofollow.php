<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Category;
use Nokaut\ApiKit\Ext\Lib\ProductsAnalyzer;

class SetIsNofollow implements CallbackInterface
{
    /**
     * @param Categories $categories
     * @param Products $products
     */
    public function __invoke(Categories $categories, Products $products)
    {
        $this->setCategoriesIsNofollow($categories, $products);
    }

    /**
     * @param Categories $categories
     * @param Products $products
     */
    protected function setCategoriesIsNofollow(Categories $categories, Products $products)
    {
        // kategorie nie wplywaja na globalny stan nofollow, nie ma znaczenia ich ilosc
        if (ProductsAnalyzer::filtersNofollow($products)) {
            /** @var Category $category */
            foreach ($categories as $category) {
                $category->setIsNofollow(true);
            }

            return;
        }
    }

    /**
     * @param Categories $categories
     * @return Category[]
     */
    protected function getSelectedCategoryEntities(Categories $categories)
    {
        return array_filter($categories->getEntities(), function ($entity) {
            return $entity->getIsFilter();
        });
    }
}