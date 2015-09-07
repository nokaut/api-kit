<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.06.2014
 * Time: 13:30
 */

namespace Nokaut\ApiKit\Entity\Product;


use Nokaut\ApiKit\Entity\EntityAbstract;

class Property extends EntityAbstract
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
     * @var mixed
     */
    protected $value;
    /**
     * @var string
     */
    protected $unit;
    /**
     * @var bool
     */
    protected $is_fight = false;
    /**
     * @var string
     */
    protected $fight_sort;

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
     * @param mixed $value - return array or int/float or string
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
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
    public function getFightSort()
    {
        return $this->fight_sort;
    }

    /**
     * @param string $fight_sort
     */
    public function setFightSort($fight_sort)
    {
        $this->fight_sort = $fight_sort;
    }
}