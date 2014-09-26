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


} 