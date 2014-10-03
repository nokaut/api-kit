<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 10.07.2014
 * Time: 14:18
 */

namespace Nokaut\ApiKit\Entity\Metadata;


use Nokaut\ApiKit\Entity\EntityAbstract;
use Nokaut\ApiKit\Entity\Metadata\Products\Paging;
use Nokaut\ApiKit\Entity\Metadata\Products\Query;
use Nokaut\ApiKit\Entity\Metadata\Products\Sort;

class ProductsMetadata extends EntityAbstract
{
    /**
     * @var int
     */
    protected $total;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $canonical;
    /**
     * @var int
     */
    protected $quality;
    /**
     * @var Paging
     */
    protected $paging;
    /**
     * @var Sort[]
     */
    protected $sorts;
    /**
     * @var Query
     */
    protected $query;

    /**
     * @param \Nokaut\ApiKit\Entity\Metadata\Products\Paging $paging
     */
    public function setPaging($paging)
    {
        $this->paging = $paging;
    }

    /**
     * @return \Nokaut\ApiKit\Entity\Metadata\Products\Paging
     */
    public function getPaging()
    {
        return $this->paging;
    }

    /**
     * @param int $quality
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;
    }

    /**
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param \Nokaut\ApiKit\Entity\Metadata\Products\Query $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return \Nokaut\ApiKit\Entity\Metadata\Products\Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param \Nokaut\ApiKit\Entity\Metadata\Products\Sort[] $sorts
     */
    public function setSorts($sorts)
    {
        $this->sorts = $sorts;
    }

    /**
     * @return \Nokaut\ApiKit\Entity\Metadata\Products\Sort[]
     */
    public function getSorts()
    {
        return $this->sorts;
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
     * @param string $canonical
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;
    }

    /**
     * @return string
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

}