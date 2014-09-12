<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 19.05.2014
 * Time: 14:43
 */

namespace Nokaut\ApiKit\Entity;


use Nokaut\ApiKit\Collection\Categories;
use Nokaut\ApiKit\Entity\Category\Path;

class Category extends EntityAbstract
{
    protected $id;
    protected $cpc_value;
    protected $depth;
    protected $description;
    protected $is_adult;
    /**
     * @var bool
     */
    protected $is_visible;

    /**
     * @var bool
     */
    protected $is_visible_on_homepage;

    protected $title;
    /**
     * @var int
     */
    protected $parent_id;
    /**
     * @var Path[]
     */
    protected $path;
    protected $photo_id;
    /**
     * @var int
     */
    protected $subcategory_count;
    protected $url;
    /**
     * @var string - picture|list
     */
    protected $view_type;
    /**
     * @var Category[]
     */
    protected $children;
    /**
     * @var int
     */
    protected $popularity;

    /**
     * @param mixed $cpc_value
     */
    public function setCpcValue($cpc_value)
    {
        $this->cpc_value = $cpc_value;
    }

    /**
     * @return mixed
     */
    public function getCpcValue()
    {
        return $this->cpc_value;
    }

    /**
     * @param mixed $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    /**
     * @return mixed
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $is_adult
     */
    public function setIsAdult($is_adult)
    {
        $this->is_adult = $is_adult;
    }

    /**
     * @return mixed
     */
    public function getIsAdult()
    {
        return $this->is_adult;
    }

    /**
     * @param boolean $is_visible
     */
    public function setIsVisible($is_visible)
    {
        $this->is_visible = $is_visible;
    }

    /**
     * @return boolean
     */
    public function getIsVisible()
    {
        return $this->is_visible;
    }

    /**
     * @param boolean $is_visible_on_homepage
     */
    public function setIsVisibleOnHomepage($is_visible_on_homepage)
    {
        $this->is_visible_on_homepage = $is_visible_on_homepage;
    }

    /**
     * @return boolean
     */
    public function getIsVisibleOnHomepage()
    {
        return $this->is_visible_on_homepage;
    }

    /**
     * @param int $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param Category\Path[] $path
     */
    public function setPath(array $path)
    {
        $this->path = $path;
    }

    /**
     * @return Category\Path[]
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $photo_id
     */
    public function setPhotoId($photo_id)
    {
        $this->photo_id = $photo_id;
    }

    /**
     * @return mixed
     */
    public function getPhotoId()
    {
        return $this->photo_id;
    }

    /**
     * @param int $subcategory_count
     */
    public function setSubcategoryCount($subcategory_count)
    {
        $this->subcategory_count = $subcategory_count;
    }

    /**
     * @return int
     */
    public function getSubcategoryCount()
    {
        return $this->subcategory_count;
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

    /**
     * @param string $view_type
     */
    public function setViewType($view_type)
    {
        $this->view_type = $view_type;
    }

    /**
     * @return string
     */
    public function getViewType()
    {
        return $this->view_type;
    }

    /**
     * @param Categories $children
     */
    public function setChildren(Categories $children)
    {
        $this->children = $children;
    }

    /**
     * @return Categories
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param int $popularity
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;
    }

    /**
     * @return int
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

}