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
    protected $fetches = array();

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator(): \Traversable
    {
        return new ArrayIterator($this->fetches);
    }

    /**
     * @param int $index
     * @return Fetch
     */
    public function getItem($index)
    {
        return $this->fetches[$index];
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
    public function count(): int
    {
        return count($this->fetches);
    }

    public function addFetch(Fetch $fetch)
    {
        $this->fetches[] = $fetch;
    }

    /**
     * @param Fetch[] $fetches
     */
    public function setFetches(array $fetches)
    {
        $this->fetches = array_values($fetches);
    }

    /**
     * @return QueryBuilderInterface[]
     */
    public function getQueries()
    {
        $queries = array();
        foreach ($this->fetches as $fetch) {
            $queries[] = $fetch->getQuery();
        }
        return $queries;
    }

    public function __clone()
    {
        $this->fetches = array_map(
            function ($fetch) {
                return clone $fetch;
            },
            $this->fetches
        );
    }
}
