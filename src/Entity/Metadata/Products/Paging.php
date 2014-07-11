<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 10.07.2014
 * Time: 14:20
 */

namespace Nokaut\ApiKit\Entity\Metadata\Products;


use Nokaut\ApiKit\Entity\EntityAbstract;

class Paging extends EntityAbstract
{
    /**
     * @var int
     */
    protected $current;
    /**
     * @var int
     */
    protected $total;
    /**
     * @var string
     */
    protected $url_template;

    /**
     * @param int $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }

    /**
     * @return int
     */
    public function getCurrent()
    {
        return $this->current;
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
     * @param string $url_template
     */
    public function setUrlTemplate($url_template)
    {
        $this->url_template = $url_template;
    }

    /**
     * @return string
     */
    public function getUrlTemplate()
    {
        return $this->url_template;
    }

}