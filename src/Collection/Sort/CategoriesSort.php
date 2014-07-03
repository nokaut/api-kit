<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.06.2014
 * Time: 10:39
 */

namespace Nokaut\ApiKit\Collection\Sort;


use Nokaut\ApiKit\Collection\AbstractCollection;
use Nokaut\ApiKit\Entity\Category;

class CategoriesSort extends Sort
{
    /**
     * @param AbstractCollection $collection
     * @param int $sorting
     */
    public static function sortByPopularity(AbstractCollection $collection, $sorting = SORT_ASC)
    {
        self::sortBy($collection,
            function (Category $category) {
                return $category->getPopularity();
            }, $sorting);
    }

    /**
     * @param AbstractCollection $collection
     * @param int $sorting
     */
    public static function sortChildrenByPopularity(AbstractCollection $collection, $sorting = SORT_ASC)
    {
        foreach ($collection as $category) {
            /** @var Category $category */
            if ($category->getChildren()) {
                $children = $category->getChildren();
                self::sortByPopularity($children, $sorting);
            }
        }
    }

    /**
     * @param AbstractCollection $collection
     * @param int $sorting
     */
    public static function sortByTitle(AbstractCollection $collection, $sorting = SORT_ASC)
    {
        self::sortBy($collection,
            function (Category $category) {
                return $category->getTitle();
            }, $sorting);
    }

    /**
     * @param AbstractCollection $collection
     * @param int $sorting
     */
    public static function sortChildrenByTitle(AbstractCollection $collection, $sorting = SORT_ASC)
    {
        foreach ($collection as $category) {
            /** @var Category $category */
            if ($category->getChildren()) {
                $children = $category->getChildren();
                self::sortByTitle($children, $sorting);
            }
        }
    }
}