<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 15:09
 */

namespace Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet;


use Nokaut\ApiKit\Entity\EntityAbstract;

class Value extends EntityAbstract
{
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

}
