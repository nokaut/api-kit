<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 13:05
 */

namespace Nokaut\ApiKit\Collection;


use Nokaut\ApiKit\Entity\Metadata\OffersMetadata;

class Offers extends CollectionAbstract
{

    /**
     * @var OffersMetadata
     */
    protected $metadata;

    /**
     * @param OffersMetadata $metadata
     */
    public function setMetadata(OffersMetadata $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return OffersMetadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    public function __clone()
    {
        parent::__clone();

        if ($this->metadata) {
            $this->metadata = clone $this->metadata;
        }
    }
}