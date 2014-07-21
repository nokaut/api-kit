<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 09:36
 */

namespace Nokaut\ApiKit\Converter\Metadata\Products;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Products\Sort;

class SortConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $sort = new Sort();

        foreach ($object as $field => $value) {
            $sort->set($field, $value);
        }

        return $sort;
    }

} 