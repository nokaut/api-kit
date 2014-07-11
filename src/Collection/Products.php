<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 20.06.2014
 * Time: 13:36
 */

namespace Nokaut\ApiKit\Collection;


use Nokaut\ApiKit\Entity\Metadata;
use Nokaut\ApiKit\Entity\Metadata\Facet\CategoryFacet;
use Nokaut\ApiKit\Entity\Metadata\Facet\PriceFacet;
use Nokaut\ApiKit\Entity\Metadata\Facet\ProducerFacet;
use Nokaut\ApiKit\Entity\Metadata\Facet\ShopFacet;
use Nokaut\ApiKit\Entity\Metadata\ProductsMetadata;
use Nokaut\ApiKit\Entity\Product;

class Products extends CollectionAbstract
{

    /**
     * @var ProductsMetadata
     */
    protected $metadata;
    /**
     * @var CategoryFacet[]
     */
    protected $categories = array();
    /**
     * @var ShopFacet[]
     */
    protected $shops = array();
    /**
     * @var ProducerFacet[]
     */
    protected $producers = array();
    /**
     * @var PriceFacet[]
     */
    protected $prices = array();

    /**
     * @param ProductsMetadata $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return ProductsMetadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param CategoryFacet[] $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return CategoryFacet[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param ShopFacet[] $shop
     */
    public function setShops($shop)
    {
        $this->shops = $shop;
    }

    /**
     * @return ShopFacet[]
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * @param ProducerFacet[] $producers
     */
    public function setProducers($producers)
    {
        $this->producers = $producers;
    }

    /**
     * @return ProducerFacet[]
     */
    public function getProducers()
    {
        return $this->producers;
    }

    /**
     * @param PriceFacet[] $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
    }

    /**
     * @return PriceFacet[]
     */
    public function getPrices()
    {
        return $this->prices;
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