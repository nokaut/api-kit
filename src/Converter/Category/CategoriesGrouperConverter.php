<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.06.2014
 * Time: 09:22
 */

namespace Nokaut\ApiKit\Converter\Category;



use Nokaut\ApiKit\Collection\Categories;
use Nokaut\ApiKit\Converter\CategoriesConverter;
use Nokaut\ApiKit\Entity\Category;

class CategoriesGrouperConverter extends CategoriesConverter
{
    public function convert(\stdClass $object)
    {
        $categories = parent::convert($object);
        return $this->joinCategoriesWithChildren($categories);
    }

    /**
     * replace plain data (parents and children) to tree data
     * @param Categories $categories
     * @return Categories
     */
    protected function joinCategoriesWithChildren(Categories $categories)
    {
        $categoriesGrouped = array();

        $groupedByParentId = $this->prepareGroupedByParentId($categories);
        $minDepth = $this->findMinDepth($categories);

        foreach ($categories as $category) {
            /** @var Category $category */
            if ($this->hasChildren($groupedByParentId, $category)) {
                $category->setChildren(new Categories($groupedByParentId[$category->getId()]));
            }
            if ($minDepth == $category->getDepth()) {
                $categoriesGrouped[] = $category;
            }
        }
        return new Categories($categoriesGrouped);
    }

    /**
     * @param Categories $categories
     * @return array - parentId => Category
     */
    private function prepareGroupedByParentId(Categories $categories)
    {
        $groupedByDepth = array();
        foreach ($categories as $category) {
            /** @var Category $category */
            if (!isset($groupedByDepth[$category->getParentId()])) {
                $groupedByDepth[$category->getParentId()] = array();
            }
            $groupedByDepth[$category->getParentId()][] = $category;
        }
        return $groupedByDepth;
    }

    /**
     * @param array $groupedByDepth
     * @param Category $category
     * @return bool
     */
    private function hasChildren(&$groupedByDepth, Category $category)
    {
        return isset($groupedByDepth[$category->getId()]);
    }

    /**
     * @param Categories $categories
     * @return int
     */
    private function findMinDepth(Categories $categories)
    {
        $minDepth = null;
        foreach ($categories as $category) {
            /** @var Category $category */
            if ($minDepth === null) {
                $minDepth = $category->getDepth();
            }
            $minDepth = min($minDepth, $category->getDepth());
        }
        return $minDepth;
    }
} 