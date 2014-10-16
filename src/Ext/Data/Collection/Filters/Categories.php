<?php

namespace Nokaut\ApiKit\Ext\Data\Collection\Filters;


use Nokaut\ApiKit\Ext\Data\Entity\Filter\ParentCategory;

class Categories extends FiltersAbstract
{
    /**
     * @var ParentCategory
     */
    protected $parentCategory;

    /**
     * @param ParentCategory $parentCategory
     */
    public function setParentCategory($parentCategory)
    {
        $this->parentCategory = $parentCategory;
    }

    /**
     * @return ParentCategory
     */
    public function getParentCategory()
    {
        return $this->parentCategory;
    }


}