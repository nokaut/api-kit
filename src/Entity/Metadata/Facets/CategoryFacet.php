<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 05.06.2014
 * Time: 14:44
 */

namespace Nokaut\ApiKit\Entity\Metadata\Facets;


use Nokaut\ApiKit\Entity\Entity;

class CategoryFacet extends Entity
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var int
     */
    protected $total;
    /**
     * @var string
     */
    protected $url;

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
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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