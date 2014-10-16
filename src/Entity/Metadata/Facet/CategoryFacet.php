<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 05.06.2014
 * Time: 14:44
 */

namespace Nokaut\ApiKit\Entity\Metadata\Facet;


use Nokaut\ApiKit\Entity\EntityAbstract;

class CategoryFacet extends EntityAbstract
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
     * @var bool
     */
    protected $is_filter = false;

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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @param boolean $is_filter
     */
    public function setIsFilter($is_filter)
    {
        $this->is_filter = $is_filter;
    }

    /**
     * @return boolean
     */
    public function getIsFilter()
    {
        return $this->is_filter;
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