<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 10:21
 */

namespace Nokaut\ApiKit\Converter\Metadata\Products;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Products\Query;

class QueryConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $query = new Query();

        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                $this->convertSubObject($query, $field, $value);
            } else {
                $query->set($field, $value);
            }
        }

        return $query;
    }

    private function convertSubObject(Query $query, $field, $value)
    {
        switch ($field) {
            case 'sort':
                $query->setSort((array)$value);
                break;
        }
    }

} 