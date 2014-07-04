<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.06.2014
 * Time: 13:47
 */

namespace Nokaut\ApiKit\Entity\Product;


use Nokaut\ApiKit\Entity\EntityAbstract;

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
    protected $url_logo;
    /**
     * @var bool
     */
    protected $high_quality;

    /**
     * @param boolean $high_quality
     */
    public function setHighQuality($high_quality)
    {
        $this->high_quality = $high_quality;
    }

    /**
     * @return boolean
     */
    public function getHighQuality()
    {
        return $this->high_quality;
    }

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
     * @param string $url_logo
     */
    public function setUrlLogo($url_logo)
    {
        $this->url_logo = $url_logo;
    }

    /**
     * @return string
     */
    public function getUrlLogo()
    {
        return $this->url_logo;
    }


} 