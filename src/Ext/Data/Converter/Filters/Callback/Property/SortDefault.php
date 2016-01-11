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

        usort($entities, function ($entity1, $entity2) use ($property) {
            $entity1Name = $entity1->getName();
            $entity2Name = $entity2->getName();
            if ($property->isPropertyRanges()) {
                list($entity1Name) = explode(" ", $entity1Name);
                list($entity2Name) = explode(" ", $entity2Name);
            }

            if (is_numeric($entity1Name) && is_numeric($entity2Name)) {
                if ($entity1Name == $entity2Name) {
                    $result = 0;
                } else {
                    $result = ($entity1Name < $entity2Name) ? -1 : 1;
                }
            } else {
                $result = strnatcmp(strtolower($entity1Name), strtolower($entity2Name));
            }

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