<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 09:31
 */

namespace Nokaut\ApiKit\Converter\Metadata\Products;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Products\Paging;

class PagingConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $paging = new Paging();

        foreach ($object as $field => $value) {
            $paging->set($field, $value);
        }
        return $paging;
    }
} 