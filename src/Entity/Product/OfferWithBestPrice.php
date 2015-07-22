<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 14.07.2014
 * Time: 09:06
 */

namespace Nokaut\ApiKit\Entity\Product;


use Nokaut\ApiKit\Entity\EntityAbstract;

class OfferWithBestPrice extends EntityAbstract
{
    /**
     * @var string
     */
    protected $click_url;
    /**
     * @var float
     */
    protected $price;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var \Nokaut\ApiKit\Entity\Offer\Shop
     */
    protected $shop;

    /**
     * @var float
     */
    protected $click_value;

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
     * @return \Nokaut\ApiKit\Entity\Offer\Shop
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * @param \Nokaut\ApiKit\Entity\Offer\Shop $shop
     */
    public function setShop($shop)
    {
        $this->shop = $shop;
    }

    /**
     * @return float
     */
    public function getClickValue()
    {
        return $this->click_value;
    }

    /**
     * @param float $click_value
     */
    public function setClickValue($click_value)
    {
        $this->click_value = $click_value;
    }

}