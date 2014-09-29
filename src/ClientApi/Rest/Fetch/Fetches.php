<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.07.2014
 * Time: 13:32
 */

namespace Nokaut\ApiKit\ClientApi\Rest\Fetch;


use ArrayIterator;
use Nokaut\ApiKit\ClientApi\Rest\Query\QueryBuilderInterface;
use Nokaut\ApiKit\Collection\CollectionInterface;
use Traversable;

class Fetches implements CollectionInterface
{
    /**
     * @var Fetch[]
     */
    protected $fetch = array();

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->fetch);
    }

    /**
     * @param int $index
     * @return Fetch
     */
    public function getItem($index)
    {
        return $this->fetch[$index];
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        count($this->fetch);
    }

    public function addFetch(Fetch $fetch)
    {
        $this->fetch[] = $fetch;
    }

    /**
     * @param Fetch[] $fetches
     */
    public function setFetches(array $fetches)
    {
        $this->fetch = $fetches;
    }

    /**
     * @return QueryBuilderInterface[]
     */
    public function getQueries()
    {
        $queries = array();
        foreach ($this->fetch as $fetch) {
            $queries[] = $fetch->getQuery();
        }
        return $queries;
    }
}
