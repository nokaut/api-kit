<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback\Property;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\PropertyAbstract;

class SortDefault implements CallbackInterface
{
    /**
     * @param PropertyAbstract $property
     * @param Products $products
     */
    public function __invoke(PropertyAbstract $property, Products $products)
    {
        $this->setPropertySort($property);
    }

    /**
     * @param PropertyAbstract $property
     */
    protected function setPropertySort(PropertyAbstract $property)
    {
        if (!$property->count()) {
            return;
        }

        $entities = $property->getEntities();

        if (!is_numeric(substr($entities[0]->getName(), 0, 1)) or strstr($entities[0]->getName(), ' x ')) {
            usort($entities, function ($entity1, $entity2) {
                return strnatcmp(strtolower($entity1->getName()), strtolower($entity2->getName()));
            });
        } else {
            usort($entities, function ($entity1, $entity2) {
                return ($entity1->getTotal() > $entity2->getTotal()) ? -1 : 1;
            });
        }
        $property->setEntities($entities);
    }
} 