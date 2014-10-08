<?php

namespace Nokaut\ApiKit\Ext\Data\Entity\Filter;


class Category extends FilterAbstract
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $url_base;
    /**
     * @var string
     */
    protected $url_in;
    /**
     * @var string
     */
    protected $url_out;

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
     * @param string $url_base
     */
    public function setUrlBase($url_base)
    {
        $this->url_base = $url_base;
    }

    /**
     * @return string
     */
    public function getUrlBase()
    {
        return $this->url_base;
    }

    /**
     * @param string $url_in
     */
    public function setUrlIn($url_in)
    {
        $this->url_in = $url_in;
    }

    /**
     * @return string
     */
    public function getUrlIn()
    {
        return $this->url_in;
    }

    /**
     * @param string $url_out
     */
    public function setUrlOut($url_out)
    {
        $this->url_out = $url_out;
    }

    /**
     * @return string
     */
    public function getUrlOut()
    {
        return $this->url_out;
    }

}