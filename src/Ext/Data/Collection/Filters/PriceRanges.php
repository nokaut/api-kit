<?php


namespace Nokaut\ApiKit\Ext\Data\Collection\Filters;


class PriceRanges extends FiltersAbstract
{
    /**
     * @var string
     */
    protected $url_in_template;

    /**
     * @param string $url_in_template
     */
    public function setUrlInTemplate($url_in_template)
    {
        $this->url_in_template = $url_in_template;
    }

    /**
     * @return string
     */
    public function getUrlInTemplate()
    {
        return $this->url_in_template;
    }
} 