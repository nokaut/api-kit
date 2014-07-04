<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 07:43
 */

namespace Nokaut\ApiKit\Converter\Category;


use Nokaut\ApiKit\Converter\ConverterInterace;
use Nokaut\ApiKit\Entity\Category\Path;

class PathConverter implements ConverterInterace
{

    public function convert(\stdClass $object)
    {
        $path = new Path();
        foreach ($object as $field => $value) {
            $path->set($field, $value);
        }
        return $path;
    }

} 