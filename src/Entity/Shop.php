<?php

namespace Nokaut\ApiKit\Entity;


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
}