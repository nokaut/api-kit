<?php

namespace Nokaut\ApiKit\Converter\Metadata\Products;


use Nokaut\ApiKit\Converter\ConverterInterface;
use Nokaut\ApiKit\Entity\Metadata\Products\Categories;

class CategoriesConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Categories
     */
    public function convert(\stdClass $object)
    {
        $categories = new Categories();

        foreach ($object as $field => $value) {
            $categories->set($field, $value);
        }
        return $categories;
    }
}