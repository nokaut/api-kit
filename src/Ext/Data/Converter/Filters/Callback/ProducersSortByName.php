<?php


namespace Nokaut\ApiKit\Ext\Data\Converter\Filters\Callback;

use Nokaut\ApiKit\Collection\Products;
use Nokaut\ApiKit\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKit\Ext\Data\Entity\Filter\Producer;

class ProducersSortByName implements ProducersCallbackInterface
{
    /**
     * @param Producers $producers
     * @param Products $products
     */
    public function __invoke(Producers $producers, Products $products)
    {
        $this->setProducersSort($producers);
    }

    /**
     * @param Producers $producers
     */
    protected function setProducersSort(Producers $producers)
    {
        $entities = $producers->getEntities();

        usort($entities, function ($producer1, $producer2) {
            /** @var Producer $producer1 */
            /** @var Producer $producer2 */
            return strnatcmp(strtolower($producer1->getName()), strtolower($producer2->getName()));
        });

        $producers->setEntities($entities);
    }
}