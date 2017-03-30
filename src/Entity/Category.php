<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 19.05.2014
 * Time: 14:43
 */

namespace Nokaut\ApiKit\Entity;


use Nokaut\ApiKit\Collection\Categories;
use Nokaut\ApiKit\Entity\Category\Complementary;
use Nokaut\ApiKit\Entity\Category\Path;

class Category extends EntityAbstract
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var float
     */
    protected $cpc_value;
    /**
     * @var int
     */
    protected $depth;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $description_html;
    /**
     * @var bool
     */
    protected $is_adult;
    /**
     * @var bool
     */
    protected $is_visible;
    /**
     * @var bool
     */
    protected $is_visible_on_homepage;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var int
     */
    protected $parent_id;
    /**
     * @var Path[]
     */
    protected $path = array();
    /**
     * @var string
     */
    protected $photo_id;
    /**
     * @var int
     */
    protected $subcategory_count;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string - picture|list
     */
    protected $view_type;
    /**
     * @var Category[]
     */
    protected $children = array();
    /**
     * @var int
     */
    protected $popularity;
    /**
     * @var int
     */
    protected $total;
    /**
     * @var string
     */
    protected $title_type_singular;
    /**
     * @var bool
     */
    protected $is_fight;
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var Complementary[]
     */
    protected $complementary;

    /**
     * @param float $cpc_value
     */
    public function setCpcValue($cpc_value)
    {
        $this->cpc_value = $cpc_value;
    }

    /**
     * @return float
     */
    public function getCpcValue()
    {
        return $this->cpc_value;
    }

    /**
     * @param int $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getDescriptionHtml()
    {
        return $this->description_html;
    }

    /**
     * @param string $description_html
     */
    public function setDescriptionHtml($description_html)
    {
        $this->description_html = $description_html;
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
     * @param bool $is_adult
     */
    public function setIsAdult($is_adult)
    {
        $this->is_adult = $is_adult;
    }

    /**
     * @return bool
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
     * @param string $photo_id
     */
    public function setPhotoId($photo_id)
    {
        $this->photo_id = $photo_id;
    }

    /**
     * @return string
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
     * @return string
     */
    public function getTitleTypeSingular()
    {
        return $this->title_type_singular;
    }

    /**
     * @param string $title_type_singular
     */
    public function setTitleTypeSingular($title_type_singular)
    {
        $this->title_type_singular = $title_type_singular;
    }


    public function __clone()
    {
        $this->path = array_map(
            function ($item) {
                return clone $item;
            },
            $this->path
        );

        $this->children = array_map(
            function ($item) {
                return clone $item;
            },
            $this->children
        );
    }

    /**
     * @return boolean
     */
    public function getIsFight()
    {
        return $this->is_fight;
    }

    /**
     * @param boolean $is_fight
     */
    public function setIsFight($is_fight)
    {
        $this->is_fight = $is_fight;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return Complementary[]
     */
    public function getComplementary()
    {
        return $this->complementary;
    }

    /**
     * @param Complementary[] $complementary
     */
    public function setComplementary($complementary)
    {
        $this->complementary = $complementary;
    }

}