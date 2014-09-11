<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 02.09.2014
 * Time: 10:39
 */

namespace Nokaut\ApiKit\Entity\Metadata\Facet;


use Nokaut\ApiKit\Entity\EntityAbstract;

class PhraseFacet extends EntityAbstract
{
    /**
     * @var string
     */
    protected $value;
    /**
     * @var string
     */
    protected $url_in_template;
    /**
     * @var string
     */
    protected $url_out;
    /**
     * @var string
     */
    protected $url_category_template;

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
    public function getUrlOut()
    {
        return $this->url_out;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $url_category_template
     */
    public function setUrlCategoryTemplate($url_category_template)
    {
        $this->url_category_template = $url_category_template;
    }

    /**
     * @return string
     */
    public function getUrlCategoryTemplate()
    {
        return $this->url_category_template;
    }

}