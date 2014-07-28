<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 10.07.2014
 * Time: 14:43
 */

namespace Nokaut\ApiKit\Entity\Metadata\Products;


use Nokaut\ApiKit\Entity\EntityAbstract;

class Query extends EntityAbstract
{
    /**
     * @var string
     */
    protected $phrase;
    /**
     * @var int
     */
    protected $offset;
    /**
     * @var int
     */
    protected $limit;

    /**
     * @var array field => order
     */
    protected $sort;

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param string $phrase
     */
    public function setPhrase($phrase)
    {
        $this->phrase = $phrase;
    }

    /**
     * @return string
     */
    public function getPhrase()
    {
        return $this->phrase;
    }

    /**
     * @param array $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return array
     */
    public function getSort()
    {
        return $this->sort;
    }
}