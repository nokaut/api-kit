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

        usort($entities, function ($entity1, $entity2) {
            $result = strnatcmp(strtolower($entity1->getName()), strtolower($entity2->getName()));

            if ($result == 0) {
                if ($entity1->getTotal() != $entity2->getTotal()) {
                    $result = ($entity1->getTotal() < $entity2->getTotal()) ? 1 : -1;
                }
            }

            return $result;
        });

        $property->setEntities($entities);
    }
} 