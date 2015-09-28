<?php

namespace Nokaut\ApiKit\Ext\Data\Collection\Filters;


use Nokaut\ApiKit\Ext\Data\Entity\Filter\ParentCategory;

class Categories extends FiltersWithUrlsAbstract
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

    public function __clone()
    {
        parent::__clone();

        if (is_object($this->parentCategory)) {
            $this->parentCategory = clone $this->parentCategory;
        }
    }

}