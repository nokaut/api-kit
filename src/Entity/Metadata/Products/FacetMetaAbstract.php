<?php

namespace Nokaut\ApiKit\Entity\Metadata\Products;


use Nokaut\ApiKit\Entity\EntityAbstract;

abstract class FacetMetaAbstract extends EntityAbstract
{
    /**
     * @var string
     */
    protected $url_out;
    /**
     * @var string
     */
    protected $url_in_template;

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
}