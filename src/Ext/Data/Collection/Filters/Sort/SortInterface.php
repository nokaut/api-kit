<?php


namespace Nokaut\ApiKit\Ext\Data\Collection\Filters\Sort;


use Nokaut\ApiKit\Ext\Data\Collection\Filters\FiltersAbstract;

interface SortInterface
{
    /**
     * @param FiltersAbstract $filters
     * @return
     */
    public static function sort(FiltersAbstract $filters);
} 