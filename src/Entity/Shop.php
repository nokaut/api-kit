<?php

namespace Nokaut\ApiKit\Entity;


use Nokaut\ApiKit\Entity\Shop\Company;
use Nokaut\ApiKit\Entity\Shop\OpineoRating;
use Nokaut\ApiKit\Entity\Shop\SalesPoint;

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
    protected $url_shop;

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
     * @var SalesPoint[]
     */
    protected $sales_points = [];

    /**
     * @var Company
     */
    protected $company;

    /**
     * @var string
     */
    protected $description;

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
    public function getUrlShop()
    {
        return $this->url_shop;
    }

    /**
     * @param string $url_shop
     */
    public function setUrlShop($url_shop)
    {
        $this->url_shop = $url_shop;
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

    /**
     * @return SalesPoint[]
     */
    public function getSalesPoints()
    {
        return $this->sales_points;
    }

    /**
     * @param SalesPoint[] $sales_points
     */
    public function setSalesPoints($sales_points)
    {
        $this->sales_points = $sales_points;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}