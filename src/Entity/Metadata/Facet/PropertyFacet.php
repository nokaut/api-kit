<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 15:01
 */

namespace Nokaut\ApiKit\Entity\Metadata\Facet;


use Nokaut\ApiKit\Entity\EntityAbstract;
use Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet\Value;
use Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet\Range;

class PropertyFacet extends EntityAbstract
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
     * @var Value[]
     */
    protected $values = array();
    /**
     * @var Range[]
     */
    protected $ranges = array();

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
     * @param Value[] $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * @return Value[]
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param \Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet\Range[] $ranges
     */
    public function setRanges($ranges)
    {
        $this->ranges = $ranges;
    }

    /**
     * @return \Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet\Range[]
     */
    public function getRanges()
    {
        return $this->ranges;
    }

}