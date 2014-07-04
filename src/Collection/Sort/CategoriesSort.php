<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.06.2014
 * Time: 10:39
 */

namespace Nokaut\ApiKit\Collection\Sort;


use Nokaut\ApiKit\Collection\CollectionAbstract;
use Nokaut\ApiKit\Entity\Category;

class CategoriesSort extends SortAbstract
{
    /**
     * @param CollectionAbstract $collection
     * @param int $sorting
     */
    public static function sortByPopularity(CollectionAbstract $collection, $sorting = SORT_ASC)
    {
        self::sortBy($collection,
            function (Category $category) {
                return $category->getPopularity();
            }, $sorting);
    }

    /**
     * @param CollectionAbstract $collection
     * @param int $sorting
     */
    public static function sortChildrenByPopularity(CollectionAbstract $collection, $sorting = SORT_ASC)
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
     * @param CollectionAbstract $collection
     * @param int $sorting
     */
    public static function sortByTitle(CollectionAbstract $collection, $sorting = SORT_ASC)
    {
        self::sortBy($collection,
            function (Category $category) {
                return $category->getTitle();
            }, $sorting);
    }

    /**
     * @param CollectionAbstract $collection
     * @param int $sorting
     */
    public static function sortChildrenByTitle(CollectionAbstract $collection, $sorting = SORT_ASC)
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