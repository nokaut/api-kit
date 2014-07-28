<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.05.2014
 * Time: 10:04
 */

namespace Nokaut\ApiKit\Converter;



use Nokaut\ApiKit\Collection\Categories;

class CategoriesConverter implements ConverterInterface
{
    private $categoryConverter;

    function __construct()
    {
        $this->categoryConverter = new CategoryConverter();
    }


    /**
     * @param \stdClass $object
     * @return Categories
     */
    public function convert(\stdClass $object)
    {
        $categoriesFromApi = $object->categories;
        $entities = array();

        foreach ($categoriesFromApi as $categoryFromApi) {
            $entities[] = $this->categoryConverter->convert($categoryFromApi);
        }
        return new Categories($entities);
    }


} 