<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 20.06.2014
 * Time: 13:36
 */

namespace Nokaut\ApiKit\Collection;


use Nokaut\ApiKit\Entity\Metadata;
use Nokaut\ApiKit\Entity\Product;

class Products extends CollectionAbstract
{

    /**
     * @var \stdClass
     */
    protected $metadata;

    /**
     * @param \stdClass $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return \stdClass
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Remove entity from collection
     * @param $id
     */
    public function removeById($id)
    {
        foreach ($this->entities as $index => $product) {
            /** @var Product $product */
            if ($product->getId() == $id) {
                unset($this->entities[$index]);
            }
        }
    }
}