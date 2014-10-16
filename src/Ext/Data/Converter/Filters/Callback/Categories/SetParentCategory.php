<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 14.10.2014
 * Time: 11:57
 */

namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Categories;


use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Entity\Category;
use Nokaut\ApiKit\Entity\Category\Path;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Categories;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\ParentCategory;

class SetParentCategory implements CallbackInterface
{
    /**
     * @var Category
     */
    protected $currentCategory;

    public function __construct(Category $currentCategory)
    {
        $this->currentCategory = $currentCategory;
    }


    /**
     * @param Categories $categories
     * @param Products $products
     */
    public function __invoke(Categories $categories, Products $products)
    {
        $pathList = $this->currentCategory->getPath();

        foreach ($pathList as $item) {
            if ($item->getId() == $this->currentCategory->getParentId()) {
                $parentCategory = $this->prepareParentCategory($item);
                $categories->setParentCategory($parentCategory);
                return;
            }
        }
    }

    /**
     * @param Path $path
     * @return ParentCategory
     */
    protected function prepareParentCategory($path)
    {
        $parentCategory = new ParentCategory();
        $parentCategory->setUrl($path->getUrl());
        $parentCategory->setName($path->getTitle());
        return $parentCategory;
    }
} 