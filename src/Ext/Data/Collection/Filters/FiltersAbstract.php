<?php

namespace Nokaut\ApiKit\Ext\Data\Collection\Filters;

use Nokaut\ApiKit\Collection\CollectionAbstract;

abstract class FiltersAbstract extends CollectionAbstract
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
    protected $unit = '';
    /**
     * @var bool
     */
    protected $is_active = false;
    /**
     * @var bool
     */
    protected $is_excluded = false;

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
     * @param boolean $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }

    /**
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param boolean $is_excluded
     */
    public function setIsExcluded($is_excluded)
    {
        $this->is_excluded = $is_excluded;
    }

    /**
     * @return boolean
     */
    public function getIsExcluded()
    {
        return $this->is_excluded;
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
     * @param string $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }
} 