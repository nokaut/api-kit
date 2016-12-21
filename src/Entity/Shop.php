<?php

namespace Nokaut\ApiKit\Entity;


use Nokaut\ApiKit\Entity\Shop\OpineoRating;

class Shop extends EntityAbstract
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $products_url;

    /**
     * @var string
     */
    protected $url_logo;

    /**
     * @var OpineoRating
     */
    protected $opineo_rating;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getProductsUrl()
    {
        return $this->products_url;
    }

    /**
     * @param string $products_url
     */
    public function setProductsUrl($products_url)
    {
        $this->products_url = $products_url;
    }

    /**
     * @return string
     */
    public function getUrlLogo()
    {
        return $this->url_logo;
    }

    /**
     * @param string $url_logo
     */
    public function setUrlLogo($url_logo)
    {
        $this->url_logo = $url_logo;
    }

    /**
     * @return OpineoRating
     */
    public function getOpineoRating()
    {
        return $this->opineo_rating;
    }

    /**
     * @param OpineoRating $opineo_rating
     */
    public function setOpineoRating($opineo_rating)
    {
        $this->opineo_rating = $opineo_rating;
    }
}