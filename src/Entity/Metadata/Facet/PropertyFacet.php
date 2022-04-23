<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 15:01
 */

namespace Nokaut\ApiKit\Entity\Metadata\Facet;


use Nokaut\ApiKit\Entity\EntityAbstract;
use Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet\Range;
use Nokaut\ApiKit\Entity\Metadata\Facet\PropertyFacet\Value;

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
     * @var string
     */
    protected $url_out;
    /**
     * @var string
     */
    protected $url_in_template;
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
     * @return string
     */
    public function getUrlOut()
    {
        return $this->url_out;
    }

    /**
     * @param string $url_out
     */
    public function setUrlOut($url_out)
    {
        $this->url_out = $url_out;
    }

    /**
     * @return string
     */
    public function getUrlInTemplate()
    {
        return $this->url_in_template;
    }

    /**
     * @param string $url_in_template
     */
    public function setUrlInTemplate($url_in_template)
    {
        $this->url_in_template = $url_in_template;
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

    public function __clone()
    {
        $this->values = array_map(
            function ($value) {
                return clone $value;
            },
            $this->values
        );
        $this->ranges = array_map(
            function ($range) {
                return clone $range;
            },
            $this->ranges
        );
    }
}