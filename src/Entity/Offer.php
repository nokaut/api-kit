<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 11:44
 */

namespace Nokaut\ApiKit\Entity;


use Nokaut\ApiKit\Entity\Offer\Property;
use Nokaut\ApiKit\Entity\Offer\Shop;

class Offer extends EntityAbstract
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $pattern_id;
    /**
     * @var int
     */
    protected $shop_id;
    /**
     * @var int
     */
    protected $shop_product_id;
    /**
     * @var bool
     */
    protected $availability;
    /**
     * @var string
     */
    protected $category;
    /**
     * @var string
     */
    protected $description_html;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var float
     */
    protected $price;
    /**
     * @var string
     */
    protected $producer;
    /**
     * @var mixed
     */
    protected $promo;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var mixed
     */
    protected $warranty;
    /**
     * @var int
     */
    protected $category_id;
    /**
     * @var string
     */
    protected $photo_id;
    /**
     * @var array
     */
    protected $photo_ids;
    /**
     * @var float
     */
    protected $cpc_value;
    /**
     * @var mixed
     */
    protected $expires_at;
    /**
     * @var mixed
     */
    protected $blocked_at;
    /**
     * @var float
     */
    protected $click_value;
    /**
     * @var bool
     */
    protected $visible;
    /**
     * @var Property[]
     */
    protected $properties;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $click_url;
    /**
     * @var Shop
     */
    protected $shop;

    /**
     * @param boolean $availability
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;
    }

    /**
     * @return boolean
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @param mixed $blocked_at
     */
    public function setBlockedAt($blocked_at)
    {
        $this->blocked_at = $blocked_at;
    }

    /**
     * @return mixed
     */
    public function getBlockedAt()
    {
        return $this->blocked_at;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
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
     * @param float $cpc_value
     */
    public function setCpcValue($cpc_value)
    {
        $this->cpc_value = $cpc_value;
    }

    /**
     * @return float
     */
    public function getCpcValue()
    {
        return $this->cpc_value;
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
     * @param mixed $expires_at
     */
    public function setExpiresAt($expires_at)
    {
        $this->expires_at = $expires_at;
    }

    /**
     * @return mixed
     */
    public function getExpiresAt()
    {
        return $this->expires_at;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $pattern_id
     */
    public function setPatternId($pattern_id)
    {
        $this->pattern_id = $pattern_id;
    }

    /**
     * @return string
     */
    public function getPatternId()
    {
        return $this->pattern_id;
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
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $producer
     */
    public function setProducer($producer)
    {
        $this->producer = $producer;
    }

    /**
     * @return string
     */
    public function getProducer()
    {
        return $this->producer;
    }

    /**
     * @param mixed $promo
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;
    }

    /**
     * @return mixed
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * @param \Nokaut\ApiKit\Entity\Offer\Property[] $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return \Nokaut\ApiKit\Entity\Offer\Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param \Nokaut\ApiKit\Entity\Offer\Shop $shop
     */
    public function setShop($shop)
    {
        $this->shop = $shop;
    }

    /**
     * @return \Nokaut\ApiKit\Entity\Offer\Shop
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * @param int $shop_id
     */
    public function setShopId($shop_id)
    {
        $this->shop_id = $shop_id;
    }

    /**
     * @return int
     */
    public function getShopId()
    {
        return $this->shop_id;
    }

    /**
     * @param int $shop_product_id
     */
    public function setShopProductId($shop_product_id)
    {
        $this->shop_product_id = $shop_product_id;
    }

    /**
     * @return int
     */
    public function getShopProductId()
    {
        return $this->shop_product_id;
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
     * @param boolean $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * @param mixed $warranty
     */
    public function setWarranty($warranty)
    {
        $this->warranty = $warranty;
    }

    /**
     * @return mixed
     */
    public function getWarranty()
    {
        return $this->warranty;
    }

}