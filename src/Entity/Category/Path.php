<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 19.05.2014
 * Time: 14:49
 */

namespace Nokaut\ApiKit\Entity\Category;


use Nokaut\ApiKit\Entity\EntityAbstract;

class Path extends EntityAbstract
{
    /**
     * @var int
     */
    protected $id;
    protected $title;
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
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }
}