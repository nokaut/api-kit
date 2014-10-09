<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.06.2014
 * Time: 13:10
 */

namespace Nokaut\ApiKit\Entity;


use Nokaut\ApiKit\Entity\Metadata\Facet\CategoryFacet;
use Nokaut\ApiKit\Entity\Product\Prices;
use Nokaut\ApiKit\Entity\Product\Property;
use Nokaut\ApiKit\Entity\Product\Rating;

class Product extends EntityAbstract
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $category_id;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $description_html;
    /**
     * @var string
     */
    protected $description_short;
    /**
     * @var Property[]
     */
    protected $properties;
    /**
     * @var array
     */
    protected $photo_ids;
    /**
     * @var string
     */
    protected $photo_id;
    /**
     * @var Prices
     */
    protected $prices;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $producer_name;
    /**
     * @var string
     */
    protected $click_url;
    /**
     * @var int
     */
    protected $offer_count;
    /**
     * @var int
     */
    protected $shop_count;
    /**
     * @var bool
     */
    protected $valid_cpa;
    /**
     * @var bool
     */
    protected $block_adsense;
    /**
     * @var mixed
     */
    protected $movie;
    /**
     * @var Product\Shop
     */
    protected $shop;
    /**
     * @var CategoryFacet
     */
    protected $category_facet;
    /**
     * @var float
     */
    protected $click_value;

    /**
     * @var Rating
     */
    protected $rating;

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
     * @param int $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param string $click_url
     */
    public function setClickUrl($click_url)
    {
        $this->click_url = $click_url;
    }

    /**
     * @return string
     */
    public function getClickUrl()
    {
        return $this->click_url;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description_html
     */
    public function setDescriptionHtml($description_html)
    {
        $this->description_html = $description_html;
    }

    /**
     * @return string
     */
    public function getDescriptionHtml()
    {
        return $this->description_html;
    }

    /**
     * @param string $description_short
     */
    public function setDescriptionShort($description_short)
    {
        $this->description_short = $description_short;
    }

    /**
     * @return string
     */
    public function getDescriptionShort()
    {
        return $this->description_short;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $movie
     */
    public function setMovie($movie)
    {
        $this->movie = $movie;
    }

    /**
     * @return mixed
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * @param int $offer_count
     */
    public function setOfferCount($offer_count)
    {
        $this->offer_count = $offer_count;
    }

    /**
     * @return int
     */
    public function getOfferCount()
    {
        return $this->offer_count;
    }

    /**
     * @param string $photo_id
     */
    public function setPhotoId($photo_id)
    {
        $this->photo_id = $photo_id;
    }

    /**
     * @return string
     */
    public function getPhotoId()
    {
        return $this->photo_id;
    }

    /**
     * @param array $photo_ids
     */
    public function setPhotoIds($photo_ids)
    {
        $this->photo_ids = $photo_ids;
    }

    /**
     * @return array
     */
    public function getPhotoIds()
    {
        return $this->photo_ids;
    }

    /**
     * @param Product\Prices $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
    }

    /**
     * @return Product\Prices
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param string $producer_name
     */
    public function setProducerName($producer_name)
    {
        $this->producer_name = $producer_name;
    }

    /**
     * @return string
     */
    public function getProducerName()
    {
        return $this->producer_name;
    }

    /**
     * @param Product\Property[] $properties
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return Product\Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param Product\Shop $shop
     */
    public function setShop($shop)
    {
        $this->shop = $shop;
    }

    /**
     * @return Product\Shop
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * @param int $shop_count
     */
    public function setShopCount($shop_count)
    {
        $this->shop_count = $shop_count;
    }

    /**
     * @return int
     */
    public function getShopCount()
    {
        return $this->shop_count;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * @param boolean $valid_cpa
     */
    public function setValidCpa($valid_cpa)
    {
        $this->valid_cpa = $valid_cpa;
    }

    /**
     * @return boolean
     */
    public function getValidCpa()
    {
        return $this->valid_cpa;
    }

    public function setCategory(CategoryFacet $category)
    {
        $this->category_facet = $category;
    }

    /**
     * @return CategoryFacet
     */
    public function getCategory()
    {
        return $this->category_facet;
    }

    /**
     * @param float $click_value
     */
    public function setClickValue($click_value)
    {
        $this->click_value = $click_value;
    }

    /**
     * @return float
     */
    public function getClickValue()
    {
        return $this->click_value;
    }

    /**
     * @param Rating $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return Rating
     */
    public function getRating()
    {
        return $this->rating;
    }

}