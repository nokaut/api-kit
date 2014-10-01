<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 23.06.2014
 * Time: 14:26
 */

namespace Nokaut\ApiKit\Collection;


use ArrayIterator;
use Nokaut\ApiKit\Entity\EntityAbstract;
use Traversable;

abstract class CollectionAbstract implements CollectionInterface
{

    protected $entities = array();

    public function __construct(array $entities)
    {
        $this->entities = array_values($entities);
    }


    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @return int
     */
    public function count()
    {
        return count($this->entities);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->entities);
    }

    /**
     * @return array
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @param array $entities
     */
    public function setEntities(array $entities)
    {
        $this->entities = array_values($entities);
    }

    public function getItem($index)
    {
        return $this->entities[$index];
    }

    public function getLast()
    {
        if (empty($this->entities)) {
            return null;
        } else {
            return end($this->entities);
        }
    }

    /**
     * Prepend element
     * @param EntityAbstract $value
     */
    public function unshift(EntityAbstract $value)
    {
        array_unshift($this->entities, $value);
    }
}