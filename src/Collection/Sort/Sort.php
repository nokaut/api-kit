<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 27.06.2014
 * Time: 10:35
 */

namespace Nokaut\ApiKit\Collection\Sort;


use Nokaut\ApiKit\Collection\AbstractCollection;

abstract class Sort {


    /**
     * @param AbstractCollection $collection
     * @param $functionGetField
     * @param $sorting
     */
    protected  static function sortBy(AbstractCollection $collection, $functionGetField, $sorting = SORT_ASC)
    {
        $values = [];
        foreach ($collection as $key => $row) {
            $values[$key] = $functionGetField($row);
        }
        $entities = $collection->getEntities();
        array_multisort($values, $sorting, $entities);
        $collection->setEntities($entities);
    }
} 