<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 27.06.2014
 * Time: 10:35
 */

namespace Nokaut\ApiKit\Collection\Sort;


use Nokaut\ApiKit\Collection\CollectionAbstract;

abstract class SortAbstract {


    /**
     * @param CollectionAbstract $collection
     * @param $functionGetField
     * @param $sorting
     */
    public static function sortBy(CollectionAbstract $collection, $functionGetField, $sorting = SORT_ASC)
    {
        $values = array();
        foreach ($collection as $key => $row) {
            $values[$key] = $functionGetField($row);
        }
        $entities = $collection->getEntities();
        array_multisort($values, $sorting, $entities);
        $collection->setEntities($entities);
    }
} 