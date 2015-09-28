<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 10.07.2014
 * Time: 14:18
 */

namespace Nokaut\ApiKit\Entity\Metadata;


use Nokaut\ApiKit\Entity\EntityAbstract;
use Nokaut\ApiKit\Entity\Metadata\Products\Categories;
use Nokaut\ApiKit\Entity\Metadata\Products\Paging;
use Nokaut\ApiKit\Entity\Metadata\Products\Prices;
use Nokaut\ApiKit\Entity\Metadata\Products\Producers;
use Nokaut\ApiKit\Entity\Metadata\Products\Properties;
use Nokaut\ApiKit\Entity\Metadata\Products\Query;
use Nokaut\ApiKit\Entity\Metadata\Products\Shops;
use Nokaut\ApiKit\Entity\Metadata\Products\Sort;

class ProductsMetadata extends EntityAbstract
{
    /**
     * @var int
     */
    protected $total;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $canonical;
    /**
     * @var int
     */
    protected $quality;
    /**
     * @var Paging
     */
    protected $paging;
    /**
     * @var Sort[]
     */
    protected $sorts;
    /**
     * @var Query
     */
    protected $query;
    /**
     * @var bool
     */
    protected $block_adsense;
    /**
     * @var Categories
     */
    protected $categories;
    /**
     * @var Shops
     */
    protected $shops;
    /**
     * @var Producers
     */
    protected $producers;
    /**
     * @var Prices
     */
    protected $prices;
    /**
     * @var Properties
     */
    protected $properties;

    /**
     * @param \Nokaut\ApiKit\Entity\Metadata\Products\Paging $paging
     */
    public function setPaging($paging)
    {
        $this->paging = $paging;
    }

    /**
     * @return \Nokaut\ApiKit\Entity\Metadata\Products\Paging
     */
    public function getPaging()
    {
        return $this->paging;
    }

    /**
     * @param int $quality
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;
    }

    /**
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param \Nokaut\ApiKit\Entity\Metadata\Products\Query $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return \Nokaut\ApiKit\Entity\Metadata\Products\Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param \Nokaut\ApiKit\Entity\Metadata\Products\Sort[] $sorts
     */
    public function setSorts($sorts)
    {
        $this->sorts = $sorts;
    }

    /**
     * @return \Nokaut\ApiKit\Entity\Metadata\Products\Sort[]
     */
    public function getSorts()
    {
        return $this->sorts;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $canonical
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;
    }

    /**
     * @return string
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @param boolean $block_adsense
     */
    public function setBlockAdsense($block_adsense)
    {
        $this->block_adsense = $block_adsense;
    }

    /**
     * @return boolean
     */
    public function getBlockAdsense()
    {
        return $this->block_adsense;
    }

    /**
     * @return Categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Categories $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return Shops
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * @param Shops $shops
     */
    public function setShops($shops)
    {
        $this->shops = $shops;
    }

    /**
     * @return Producers
     */
    public function getProducers()
    {
        return $this->producers;
    }

    /**
     * @param Producers $producers
     */
    public function setProducers($producers)
    {
        $this->producers = $producers;
    }

    /**
     * @return Prices
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param Prices $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
    }

    /**
     * @return Properties
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param Properties $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    public function __clone()
    {
        if (is_object($this->paging)) {
            $this->paging = clone $this->paging;
        }

        if (is_object($this->query)) {
            $this->query = clone $this->query;
        }

        $this->sorts = array_map(
            function ($sort) {
                return clone $sort;
            },
            $this->sorts
        );

        if (is_object($this->categories)) {
            $this->categories = clone $this->categories;
        }

        if (is_object($this->shops)) {
            $this->shops = clone $this->shops;
        }

        if (is_object($this->producers)) {
            $this->producers = clone $this->producers;
        }

        if (is_object($this->prices)) {
            $this->prices = clone $this->prices;
        }

        if (is_object($this->properties)) {
            $this->properties = clone $this->properties;
        }
    }
}