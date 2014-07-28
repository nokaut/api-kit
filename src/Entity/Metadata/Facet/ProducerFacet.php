<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 14:03
 */

namespace Nokaut\ApiKit\Entity\Metadata\Facet;


use Nokaut\ApiKit\Entity\EntityAbstract;

class ProducerFacet extends EntityAbstract
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string $name
     */
    protected $name;
    /**
     * @var $int
     */
    protected $total;
    /**
     * @var string
     */
    protected $url;

    /**
     * @var bool
     */
    protected $is_filter = false;

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
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
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

} 