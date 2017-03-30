<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 30.03.2017
 * Time: 13:25
 */

namespace Nokaut\ApiKit\Converter\Category;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Category\Complementary;

class ComplementaryConverter implements ConverterInterface
{

    public function convert(\stdClass $object)
    {
        $result = [];
        for ($priority = 1; $priority <= 10; ++$priority) {
            if (isset($object->$priority)) {
                $result[] = $complementary = new Complementary();
                $complementary->setCategoryId($object->$priority);
                $complementary->setPriority($priority);
            }
        }
        return $result;
    }
}